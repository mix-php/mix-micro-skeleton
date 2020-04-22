<?php

namespace App\JsonRpc\Commands;

/**
 * Class CurlCommand
 * @package App\JsonRpc\Commands
 */
class CurlCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 注册
        $this->server->register(\App\JsonRpc\Services\CurlService::class);
    }

}