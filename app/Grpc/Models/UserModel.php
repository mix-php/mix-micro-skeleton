<?php

namespace App\Grpc\Models;

use Mix\Database\Database;
use Php\Micro\Grpc\User\Userinfo;

/**
 * Class UserModel
 * @package App\Grpc\Models
 * @author liu,jian <coder.keda@gmail.com>
 */
class UserModel
{

    /**
     * @var Database
     */
    public $db;

    /**
     * UserModel constructor.
     */
    public function __construct()
    {
        $this->db = context()->get('database');
    }

    /**
     * 新增用户
     * @param Userinfo $request
     * @return bool|string
     */
    public function add(Userinfo $userinfo)
    {
        $db       = $this->db->insert('user', [
            'name'  => $userinfo->getName(),
            'age'   => $userinfo->getAge(),
            'email' => $userinfo->getEmail(),
        ]);
        $status   = $db->execute();
        $insertId = $status ? $db->getLastInsertId() : false;
        return $insertId;
    }

    /**
     * 获取用户
     * @param string $id
     * @return array
     */
    public function get(string $id)
    {
        return $this->db->table('user')->where(['id', '=', $id])->get();
    }

}
