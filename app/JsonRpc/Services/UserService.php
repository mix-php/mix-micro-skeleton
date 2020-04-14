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
        $model = new UserModel();
        $model->add($user);
        return ['status' => 'success'];
    }

}
