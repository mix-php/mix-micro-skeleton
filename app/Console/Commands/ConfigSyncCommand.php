<?php

namespace App\Console\Commands;

use Mix\Monolog\Logger;
use Mix\Monolog\Handler\RotatingFileHandler;
use Mix\Micro\Etcd\Config;
use Mix\Signal\SignalNotify;
use Mix\Time\Ticker;
use Mix\Time\Time;

/**
 * Class ConfigSyncCommand
 * @package App\Console\Commands
 */
class ConfigSyncCommand
{

    /**
     * @var Config
     */
    public $config;

    /**
     * @var Logger
     */
    public $logger;

    /**
     * @var Ticker
     */
    public $ticker;

    /**
     * ConfigPutCommand constructor.
     */
    public function __construct()
    {
        $this->logger = context()->get('logger');
        $this->config = context()->get(Config::class);

        // 设置日志处理器
        $this->logger->withName('CONSOLE');
        $handler = new RotatingFileHandler(sprintf('%s/runtime/logs/console.log', app()->basePath), 7);
        $this->logger->pushHandler($handler);
    }

    /**
     * 主函数
     */
    public function main()
    {
        // 捕获信号
        $notify = new SignalNotify(SIGINT, SIGTERM, SIGQUIT);
        xgo(function () use ($notify) {
            $signal = $notify->channel()->pop();
            $this->logger->info('Received signal [{signal}]', ['signal' => $signal]);
            $this->logger->info('Sync stop');
            $this->ticker->stop();
            $this->config->close();
            $notify->stop();
        });

        // 同步配置文件到配置中心
        // 可以通过两种方式实现与 git 仓库的配置文件同步
        // 1. 在命令行程序中用定时器，定时同步配置到配置中心
        // 2. 写一个 api 接口，在 git webhook 中设置该接口，然后接口中使用 sync 方法同步配置到配置中心
        $this->logger->info('Sync start');

        // 定时同步配置到配置中心
        $ticker = $this->ticker = Time::newTicker(5 * Time::SECOND);
        xgo(function () use ($ticker) {
            while (true) {
                $ts = $ticker->channel()->pop();
                if (!$ts) {
                    return;
                }
                $path = sprintf('%s/config', app()->basePath);
                $this->config->sync($path);
            }
        });
    }

}
