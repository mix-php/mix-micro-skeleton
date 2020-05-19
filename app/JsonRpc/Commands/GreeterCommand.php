<?php

namespace App\JsonRpc\Commands;

/**
 * Class GreeterCommand
 * @package App\JsonRpc\Commands
 */
class GreeterCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 注册处理程序
        $this->server->register(\App\JsonRpc\Services\Greeter\SayService::class);
        $this->server->register(\App\JsonRpc\Services\Greeter\CarryService::class);
    }

}