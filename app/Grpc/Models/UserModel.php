<?php

namespace App\Grpc\Models;

use Mix\Database\Pool\ConnectionPool;
use Php\Micro\Grpc\User\Request;

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
     * @param Request $request
     * @return bool|string
     */
    public function add(Request $request)
    {
        $db       = $this->pool->getConnection();
        $status   = $db->insert('user', [
            'name'  => $request->getName(),
            'age'   => $request->getAge(),
            'email' => $request->getEmail(),
        ])->execute();
        $insertId = $status ? $db->getLastInsertId() : false;
        $db->release();
        return $insertId;
    }

}
