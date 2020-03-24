<?php

namespace App\Api\Models;

use App\Api\Forms\UserForm;
use Mix\Database\Pool\ConnectionPool;

/**
 * Class UserModel
 * @package App\Api\Models
 * @author liu,jian <coder.keda@gmail.com>
 */
class UserModel
{

    /**
     * @var ConnectionPool
     */
    public $pool;

    /**
     * UserModel constructor.
     */
    public function __construct()
    {
        $this->pool = context()->get('dbPool');
    }

    /**
     * 新增用户
     * @param array $user
     * @return bool|string
     */
    public function add(array $user)
    {
        $db       = $this->pool->getConnection();
        $status   = $db->insert('user', [
            'name'  => $user['name'],
            'age'   => $user['age'],
            'email' => $user['email'],
        ])->execute();
        $insertId = $status ? $db->getLastInsertId() : false;
        $db->release();
        return $insertId;
    }

}
