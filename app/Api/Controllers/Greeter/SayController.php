<?php

namespace App\Api\Controllers\Greeter;

use App\Common\Helpers\ResponseHelper;
use Mix\Context\Context;
use Mix\Http\Message\ServerRequest;
use Mix\Http\Message\Response;
use Mix\Grpc\Client\Dialer;
use Mix\Micro\Hystrix\CircuitBreaker;
use Mix\Tracing\Grpc\TracingClientMiddleware;
use Mix\Tracing\Tracing;
use Php\Micro\Grpc\Greeter\Request;
use Php\Micro\Grpc\Greeter\SayClient;

/**
 * Class SayController
 * @package App\Api\Controllers\Greeter
 */
class SayController
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
     * SayController constructor.
     */
    public function __construct()
    {
        $this->dialer  = context()->get(Dialer::class);
        $this->breaker = context()->get(CircuitBreaker::class);
    }

    /**
     * Hello
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     */
    public function hello(ServerRequest $request, Response $response)
    {
        $name = $request->getAttribute('name', '?');

        // 使用熔断器调用 (gRPC)
        $result = $this->breaker->do('php.micro', function () use ($request, $name) {
            // 调用rpc
            $tracer     = Tracing::extract($request->getContext());
            $middleware = new TracingClientMiddleware($tracer);
            $client     = new SayClient($this->dialer->dialFromService('php.micro.grpc.greeter', $middleware));
            $rpcRequest = new Request();
            $rpcRequest->setName($name);
            $rpcResponse = $client->Hello(new Context(), $rpcRequest);
            return $rpcResponse->getMsg();
        }, function () use ($name) {
            // 返回本地数据或抛出异常
            return sprintf('hello, %s', $name);
        });

        $data = [
            'code'    => 0,
            'message' => $result,
        ];
        return ResponseHelper::json($response, $data);
    }

}
