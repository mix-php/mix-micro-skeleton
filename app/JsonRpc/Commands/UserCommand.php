<?php

namespace App\JsonRpc\Commands;

/**
 * Class UserCommand
 * @package App\JsonRpc\Commands
 */
class UserCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 注册处理程序
        $this->server->register(\App\JsonRpc\Services\UserService::class);
    }

}