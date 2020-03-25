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
     * @param array $user
     * @return array
     */
    public function Add(array $user): array
    {
        $model = new UserModel();
        $model->add($user);
        return ['status' => 'success'];
    }

}
