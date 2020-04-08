<?php

namespace App\Api\Controllers;

use App\Common\Helpers\ResponseHelper;
use App\Api\Forms\UserForm;
use Mix\Http\Message\Response;
use Mix\Http\Message\ServerRequest;
use Mix\JsonRpc\Client\Dialer;
use Mix\JsonRpc\Factory\RequestFactory;

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
        $conn        = $this->dialer->dialFromService('php.micro.jsonrpc.user');
        $rpcRequest  = (new RequestFactory)->createRequest('User.Add', [$form], 10001);
        $rpcResponse = $conn->call($rpcRequest);
        if ($rpcResponse->error) {
            $error = $rpcResponse->error;
            throw new \Exception(sprintf('RPC call failed: %s', $error->message), $error->code);
        }

        // 响应
        $content = ['code' => 0, 'message' => 'OK'];
        return ResponseHelper::json($response, $content);
    }

}
