<?php

namespace App\Console\Commands;

use Mix\Helper\ProcessHelper;
use Mix\Micro\Etcd\Configurator;
use Mix\Log\Logger;

/**
 * Class ConfigSyncCommand
 * @package App\Console\Commands
 */
class ConfigSyncCommand
{

    /**
     * @var Configurator
     */
    public $config;

    /**
     * @var Logger
     */
    public $log;

    /**
     * ConfigPutCommand constructor.
     */
    public function __construct()
    {
        $this->log    = context()->get('log');
        $this->config = context()->get(Configurator::class);

        $this->log->withName('CONSOLE');
        $handler = new \Mix\Log\Handler\RotatingFileHandler(sprintf('%s/runtime/logs/console.log', app()->basePath), 7);
        $this->log->pushHandler($handler);
    }

    /**
     * 主函数
     */
    public function main()
    {
        // 捕获信号
        ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], function ($signal) {
            $this->log->info('Received signal [{signal}]', ['signal' => $signal]);
            $this->log->info('Sync stop');
            $this->config->close();
            ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], null);
        });

        // 同步配置文件到配置中心
        // 通常正式环境应该使用一个单独的 git 仓库存放配置文件，达到通过 git 修改配置自动同步到配置中心的效果
        $this->log->info('Sync start');
        $path = sprintf('%s/config', app()->basePath);
        $this->config->sync($path);
    }

}
