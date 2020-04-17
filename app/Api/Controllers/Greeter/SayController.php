<?php

namespace App\Api\Controllers\Greeter;

use App\Common\Helpers\ResponseHelper;
use Mix\Http\Message\ServerRequest;
use Mix\Http\Message\Response;
use Mix\Grpc\Client\Dialer;
use Mix\Micro\Hystrix\CircuitBreaker;
use Mix\Tracing\Middleware\Grpc\TracingClientMiddleware;
use Mix\Zipkin\Tracing;
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
     * Hello
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     */
    public function hello(ServerRequest $request, Response $response)
    {
        $name = $request->getAttribute('name', '?');

        // 使用熔断器调用 (gRPC)
        $result = $this->breaker->do('php.micro.jsonrpc.greeter', function () use ($request, $name) {
            // 调用rpc
            $tracer     = Tracing::extract($request->getContext());
            $middleware = new TracingClientMiddleware($tracer);
            /** @var SayClient $client */
            $client     = $this->dialer->dialFromService('php.micro.grpc.greeter', SayClient::class, $middleware);
            $rpcRequest = new Request();
            $rpcRequest->setName($name);
            $rpcResponse = $client->Hello($rpcRequest);
            return $rpcResponse->getMsg();
        }, function () use ($name) {
            // 返回本地数据或抛出异常
            return sprintf('hello, %s', $name);
        });

        /*
        // 使用熔断器调用 (jsonrpc)
        $result = $this->breaker->do('php.micro.jsonrpc.greeter', function () use ($request, $name) {
            // 调用rpc
            $tracer      = Tracing::extract($request->getContext());
            $middleware  = new TracingClientMiddleware($tracer);
            $conn        = $this->dialer->dialFromService('php.micro.jsonrpc.greeter', $middleware);
            $rpcRequest  = (new RequestFactory)->createRequest('Say.Hello', [$name]);
            $rpcResponse = $conn->call($rpcRequest);
            if ($rpcResponse->error) {
                $error = $rpcResponse->error;
                throw new \Exception(sprintf('RPC call failed: %s', $error->message), $error->code);
            }
            return $rpcResponse->result;
        }, function () use ($name) {
            // 返回本地数据或抛出异常
            return sprintf('hello, %s', $name);
        });
        */

        $data = [
            'code'    => 0,
            'message' => $result,
        ];
        return ResponseHelper::json($response, $data);
    }

}
