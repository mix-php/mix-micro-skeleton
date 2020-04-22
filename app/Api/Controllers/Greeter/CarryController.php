<?php

namespace App\Api\Controllers\Greeter;

use App\Common\Helpers\ResponseHelper;
use Mix\Http\Message\ServerRequest;
use Mix\Http\Message\Response;
use Mix\Grpc\Client\Dialer;
use Mix\Micro\Hystrix\CircuitBreaker;
use Mix\Tracing\Grpc\TracingClientMiddleware;
use Mix\Tracing\Zipkin\Tracing;
use Php\Micro\Grpc\Greeter\CarryClient;
use Php\Micro\Grpc\Greeter\Request;

/**
 * Class CarryController
 * @package App\Api\Controllers\Greeter
 */
class CarryController
{

    /**
     * @var Dialer
     */
    public $dialer;

    /**
     * @var CircuitBreaker
     */
    public $breaker;

    /**
     * FileController constructor.
     * @param ServerRequest $request
     * @param Response $response
     */
    public function __construct(ServerRequest $request, Response $response)
    {
        $this->dialer  = context()->get(Dialer::class);
        $this->breaker = context()->get(CircuitBreaker::class);
    }

    /**
     * Luggage
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     */
    public function luggage(ServerRequest $request, Response $response)
    {
        $name = $request->getAttribute('name', '?');

        // 使用熔断器调用 (gRPC)
        $result = $this->breaker->do('php.micro', function () use ($request, $name) {
            // 调用rpc
            $tracer     = Tracing::extract($request->getContext());
            $middleware = new TracingClientMiddleware($tracer);
            /** @var CarryClient $client */
            $client     = $this->dialer->dialFromService('php.micro.grpc.greeter', CarryClient::class, $middleware);
            $rpcRequest = new Request();
            $rpcRequest->setName($name);
            $rpcResponse = $client->Luggage($rpcRequest);
            return $rpcResponse->getMsg();
        }, function () use ($name) {
            // 返回本地数据或抛出异常
            return sprintf('carry %s', $name);
        });

        $data = [
            'code'    => 0,
            'message' => $result,
        ];
        return ResponseHelper::json($response, $data);
    }

}
