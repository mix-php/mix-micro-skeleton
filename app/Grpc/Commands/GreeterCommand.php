<?php

namespace App\Grpc\Commands;

/**
 * Class GreeterCommand
 * @package App\Grpc\Commands
 */
class GreeterCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 注册处理程序
        $this->server->register(\App\Grpc\Services\Greeter\SayService::class);
        $this->server->register(\App\Grpc\Services\Greeter\CarryService::class);
    }

}