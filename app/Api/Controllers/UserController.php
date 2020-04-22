<?php

namespace App\Api\Controllers;

use App\Common\Helpers\ResponseHelper;
use App\Api\Forms\UserForm;
use Mix\Http\Message\Response;
use Mix\Http\Message\ServerRequest;
use Mix\Grpc\Client\Dialer;
use Mix\Tracing\Grpc\TracingClientMiddleware;
use Mix\Tracing\Zipkin\Tracing;
use Php\Micro\Grpc\User\AddRequest;
use Php\Micro\Grpc\User\UserClient;
use Php\Micro\Grpc\User\Userinfo;

/**
 * Class UserController
 * @package App\Api\Controllers
 * @author liu,jian <coder.keda@gmail.com>
 */
class UserController
{

    /**
     * @var Dialer
     */
    public $dialer;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->dialer = context()->get(Dialer::class);
    }

    /**
     * Create
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     * @throws \Exception
     */
    public function create(ServerRequest $request, Response $response)
    {
        // 使用表单验证器
        $form = new UserForm($request->getAttributes());
        $form->setScenario('create');
        if (!$form->validate()) {
            $content = ['code' => 1, 'message' => 'FAILED', 'data' => $form->getErrors()];
            return ResponseHelper::json($response, $content);
        }

        // 调用rpc保存用户信息
        $tracer     = Tracing::extract($request->getContext());
        $middleware = new TracingClientMiddleware($tracer);
        /** @var UserClient $client */
        $client   = $this->dialer->dialFromService('php.micro.grpc.user', UserClient::class, $middleware);
        $userinfo = new Userinfo();
        $userinfo->setName('xiaoming');
        $userinfo->setAge('12');
        $userinfo->setEmail('foo@bar.com');
        $rpcRequest = new AddRequest();
        $rpcRequest->setUserinfo($userinfo);
        $rpcResponse = $client->Add($rpcRequest);
        $status      = $rpcResponse->getStatus();

        // 响应
        $content = ['code' => 0, 'message' => $status];
        return ResponseHelper::json($response, $content);
    }

}
