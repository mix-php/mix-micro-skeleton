<?php

namespace App\JsonRpc\Models;

use Mix\Database\Pool\ConnectionPool;

/**
 * Class UserModel
 * @package App\JsonRpc\Models
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
     * @param object $user
     * @return bool|string
     */
    public function add(object $user)
    {
        $db       = $this->pool->getConnection();
        $status   = $db->insert('user', [
            'name'  => $user->name,
            'age'   => $user->age,
            'email' => $user->email,
        ])->execute();
        $insertId = $status ? $db->getLastInsertId() : false;
        $db->release();
        return $insertId;
    }

    /**
     * 获取用户
     * @param string $id
     * @return array
     */
    public function get(string $id)
    {
        $db = $this->pool->getConnection();
        return $db->table('user')->where(['id', '=', $id])->get();
    }

}
