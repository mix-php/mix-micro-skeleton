<?php

namespace App\JsonRpc\Services;

use App\JsonRpc\Models\UserModel;
use Mix\Context\Context;
use Mix\JsonRpc\ServiceInterface;

/**
 * Class UserService
 * @package App\JsonRpc\Services
 */
class UserService implements ServiceInterface
{

    /**
     * Service name
     * @var string
     */
    public const NAME = "php.micro.jsonrpc.user.User";

    /**
     * Add
     * @param Context $context
     * @param object $user
     * @return array
     */
    public function Add(Context $context, object $user): array
    {
        $model  = new UserModel();
        $result = $model->add($user);
        if ($result) {
            $status = 'success';
        } else {
            $status = 'fail';
        }
        return ['status' => $status];
    }

    /**
     * Get
     * @param Context $context
     * @param object $user
     * @return array
     */
    public function Get(Context $context, string $id): array
    {
        $model  = new UserModel();
        $result = $model->get($id);
        if ($result) {
            $status   = 'success';
            $userinfo = [
                'name'  => $result['name'],
                'age'   => $result['age'],
                'email' => $result['email'],
            ];
        } else {
            $status   = 'fail';
            $userinfo = (object)[];
        }
        return ['status' => $status, 'userinfo' => $userinfo];
    }

}
