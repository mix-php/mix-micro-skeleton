<?php

namespace App\Grpc\Services;

use App\Grpc\Models\UserModel;
use Mix\Context\Context;
use Mix\Grpc;
use Php\Micro\Grpc\User\AddRequest;
use Php\Micro\Grpc\User\AddResponse;
use Php\Micro\Grpc\User\GetRequest;
use Php\Micro\Grpc\User\GetResponse;
use Php\Micro\Grpc\User\Userinfo;
use Php\Micro\Grpc\User\UserInterface;

/**
 * Class UserService
 * @package App\Grpc\Services
 */
class UserService implements UserInterface
{

    /**
     * Add
     * @param Context $context
     * @param AddRequest $request
     * @return AddResponse
     */
    public function Add(Context $context, AddRequest $request): AddResponse
    {
        $model    = new UserModel();
        $result   = $model->add($request->getUserinfo());
        $response = new AddResponse();
        if ($result) {
            $response->setStatus('success');
        } else {
            $response->setStatus('fail');
        }
        return $response;
    }

    /**
     * Get
     * @param Context $context
     * @param GetRequest $request
     * @return GetResponse
     *
     * @throws Grpc\Exception\InvokeException
     */
    public function Get(Context $context, GetRequest $request): GetResponse
    {
        $model    = new UserModel();
        $result   = $model->get($request->getId());
        $response = new GetResponse();
        if ($result) {
            $userinfo = new Userinfo();
            $userinfo->setName($result['name']);
            $userinfo->setAge($result['age']);
            $userinfo->setEmail($result['email']);
            $response->setStatus('success');
            $response->setUserinfo($userinfo);
        } else {
            $response->setStatus('fail');
        }
        return $response;
    }

}
