<?php

namespace App\Grpc\Commands;

/**
 * Class UserCommand
 * @package App\Grpc\Commands
 */
class UserCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 注册
        $this->server->register(\App\Grpc\Services\UserService::class);
    }

}