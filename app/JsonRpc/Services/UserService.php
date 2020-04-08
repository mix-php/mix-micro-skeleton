<?php

namespace App\JsonRpc\Services;

use App\JsonRpc\Models\UserModel;
use Mix\JsonRpc\Message\Context;

/**
 * Class UserService
 * @package App\JsonRpc\Services
 */
class UserService
{

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
