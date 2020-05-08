<?php

namespace App\Console\Commands;

use Mix\Helper\ProcessHelper;
use Mix\Log\Logger;
use Mix\Log\Handler\RotatingFileHandler;
use Mix\Micro\Etcd\Configurator;
use Mix\Concurrent\Timer;

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
     * @var Timer
     */
    public $timer;

    /**
     * ConfigPutCommand constructor.
     */
    public function __construct()
    {
        $this->log    = context()->get('log');
        $this->config = context()->get(Configurator::class);
        // 设置日志处理器
        $this->log->withName('CONSOLE');
        $handler = new RotatingFileHandler(sprintf('%s/runtime/logs/console.log', app()->basePath), 7);
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
            $this->timer->clear();
            $this->config->close();
            ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], null);
        });

        // 同步配置文件到配置中心
        // 可以通过两种方式实现与 git 仓库管理配置文件
        // 1. 在命令行程序中用定时器，定时同步配置到配置中心
        // 2. 写一个 api 接口，在 git webhook 中设置该接口，然后接口中使用 sync 方法同步配置到配置中心
        $this->log->info('Sync start');

        // 定时同步配置到配置中心
        $path  = sprintf('%s/config', app()->basePath);
        $timer = Timer::new();
        $timer->tick(5000, function () use ($path) {
            $this->config->sync($path);
        });
        $this->timer = $timer;
    }

}
