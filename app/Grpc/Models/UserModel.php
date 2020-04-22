<?php

namespace App\Grpc\Models;

use Mix\Database\Pool\ConnectionPool;
use Php\Micro\Grpc\User\Userinfo;

/**
 * Class UserModel
 * @package App\Grpc\Models
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
     * @param Userinfo $request
     * @return bool|string
     */
    public function add(Userinfo $userinfo)
    {
        $db       = $this->pool->getConnection();
        $status   = $db->insert('user', [
            'name'  => $userinfo->getName(),
            'age'   => $userinfo->getAge(),
            'email' => $userinfo->getEmail(),
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
