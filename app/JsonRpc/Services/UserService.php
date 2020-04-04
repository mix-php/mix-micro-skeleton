<?php

namespace App\JsonRpc\Services;

use App\JsonRpc\Models\UserModel;

/**
 * Class UserService
 * @package App\JsonRpc\Services
 */
class UserService
{

    /**
     * Add
     * @param object $user
     * @return array
     */
    public function Add(object $user): array
    {
        $model = new UserModel();
        $model->add($user);
        return ['status' => 'success'];
    }

}
