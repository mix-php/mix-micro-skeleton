<?php

namespace App\JsonRpc\Models;

use Mix\Database\Database;

/**
 * Class UserModel
 * @package App\JsonRpc\Models
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
     * @param object $user
     * @return bool|string
     */
    public function add(object $user)
    {
        $db       = $this->db->insert('user', [
            'name'  => $user->name,
            'age'   => $user->age,
            'email' => $user->email,
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
