<?php

namespace App\Api\Controllers\Greeter;

use App\Common\Helpers\ResponseHelper;
use Mix\Http\Message\ServerRequest;
use Mix\Http\Message\Response;
use Mix\JsonRpc\Client\Dialer;
use Mix\JsonRpc\Factory\RequestFactory;
use Mix\JsonRpc\Helper\JsonRpcHelper;
use Mix\Micro\Breaker\CircuitBreaker;

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

        // 使用熔断器调用
        $result = $this->breaker->do('php.micro.jsonrpc.greeter', function () use ($request, $name) {
            // 调用rpc
            $conn                 = $this->dialer->dialFromService('php.micro.jsonrpc.greeter');
            $rpcRequest           = (new RequestFactory)->createRequest('Say.Hello', [$name], 10001);
            $rpcRequest->metadata = JsonRpcHelper::parseMetadata($request);
            $rpcResponse          = $conn->call($rpcRequest);
            if ($rpcResponse->error) {
                $error = $rpcResponse->error;
                throw new \Exception(sprintf('RPC call failed: %s', $error->message), $error->code);
            }
            return $rpcResponse->result;
        }, function () use ($name) {
            // 返回本地数据或抛出异常
            return [sprintf('hello, %s', $name)];
        });

        $data = [
            'code'    => 0,
            'message' => array_pop($result),
        ];
        return ResponseHelper::json($response, $data);
    }

}
