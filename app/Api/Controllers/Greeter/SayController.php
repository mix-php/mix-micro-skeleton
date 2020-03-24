<?php

namespace App\Api\Controllers\Greeter;

use App\Common\Helpers\ResponseHelper;
use Mix\Http\Message\ServerRequest;
use Mix\Http\Message\Response;
use Mix\JsonRpc\Client\Dialer;
use Mix\JsonRpc\Factory\RequestFactory;

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
     * FileController constructor.
     * @param ServerRequest $request
     * @param Response $response
     */
    public function __construct(ServerRequest $request, Response $response)
    {
        $this->dialer = context()->get(Dialer::class);
    }

    /**
     * Hello
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     * @throws \Mix\JsonRpc\Exception\ParseException
     * @throws \PhpDocReader\AnnotationException
     * @throws \ReflectionException
     * @throws \Swoole\Exception
     */
    public function hello(ServerRequest $request, Response $response)
    {
        $name = $request->getAttribute('name', '?');

        // 调用rpc
        $conn        = $this->dialer->dialFromService('php.micro.jsonrpc.greeter');
        $rpcRequest  = (new RequestFactory)->createRequest('Say.Hello', [$name], 10001);
        $rpcResponse = $conn->call($rpcRequest);
        if ($rpcResponse->error) {
            $error = $rpcResponse->error;
            throw new \Exception(sprintf('RPC call failed: %s', $error->message), $error->code);
        }

        $data = [
            'code'    => 0,
            'message' => array_pop($rpcResponse->result),
        ];
        return ResponseHelper::json($response, $data);
    }

}
