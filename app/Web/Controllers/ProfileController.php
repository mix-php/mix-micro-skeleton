<?php

namespace App\Web\Controllers;

use App\Common\Helpers\ResponseHelper;
use Mix\Grpc\Client\Dialer;
use Mix\Http\Message\Response;
use Mix\Http\Message\ServerRequest;
use Mix\Tracing\Grpc\TracingClientMiddleware;
use Mix\Tracing\Zipkin\Tracing;
use Php\Micro\Grpc\User\GetRequest;
use Php\Micro\Grpc\User\UserClient;

/**
 * Class ProfileController
 * @package App\Web\Controllers
 * @author liu,jian <coder.keda@gmail.com>
 */
class ProfileController
{

    /**
     * @var Dialer
     */
    public $dialer;

    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->dialer = context()->get(Dialer::class);
    }

    /**
     * Index
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     * @throws \PhpDocReader\AnnotationException
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function index(ServerRequest $request, Response $response)
    {
        $id = $request->getAttribute('id');

        // 调用rpc获取用户信息
        $tracer     = Tracing::extract($request->getContext());
        $middleware = new TracingClientMiddleware($tracer);
        /** @var UserClient $client */
        $client     = $this->dialer->dialFromService('php.micro.grpc.user', UserClient::class, $middleware);
        $rpcRequest = new GetRequest();
        $rpcRequest->setId($id);
        $rpcResponse = $client->Get($rpcRequest);
        $status      = $rpcResponse->getStatus();
        if ($status != 'success') {
            throw new \Exception('User not found');
        }
        $userinfo = $rpcResponse->getUserinfo();

        // 渲染数据
        $data = [
            'id'    => $id,
            'name'  => $userinfo->getName(),
            'age'   => $userinfo->getAge(),
            'email' => $userinfo->getEmail(),
        ];
        return ResponseHelper::view($response, 'profile.index', $data);
    }

}
