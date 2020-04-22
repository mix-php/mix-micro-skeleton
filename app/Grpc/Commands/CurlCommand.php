<?php

namespace App\Grpc\Commands;

/**
 * Class CurlCommand
 * @package App\Grpc\Commands
 */
class CurlCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 注册
        $this->server->register(\App\Grpc\Services\CurlService::class);
    }

}