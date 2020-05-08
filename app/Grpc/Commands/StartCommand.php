<?php

namespace App\Grpc\Commands;

use Mix\Concurrent\Timer;
use Mix\Event\EventDispatcher;
use Mix\Log\Logger;
use Mix\Log\Handler\RotatingFileHandler;
use Mix\Micro\Etcd\Configurator;
use Mix\Micro\Etcd\Factory\ServiceFactory;
use Mix\Micro\Etcd\Registry;
use Mix\Helper\ProcessHelper;
use Mix\Grpc\Server;

/**
 * Class StartCommand
 * @package App\Grpc\Commands
 */
abstract class StartCommand
{

    /**
     * @var Server
     */
    public $server;

    /**
     * @var Configurator
     */
    public $config;

    /**
     * @var Registry
     */
    public $registry;

    /**
     * @var Logger
     */
    public $log;

    /**
     * StartCommand constructor.
     */
    public function __construct()
    {
        $this->log      = context()->get('log');
        $this->server   = context()->get(Server::class);
        $this->config   = context()->get(Configurator::class);
        $this->registry = context()->get(Registry::class);
        // 设置日志处理器
        $this->log->withName('GRPC');
        $handler = new RotatingFileHandler(sprintf('%s/runtime/logs/grpc.log', app()->basePath), 7);
        $this->log->pushHandler($handler);
    }

    /**
     * 主函数
     * @throws \Swoole\Exception
     */
    public function main()
    {
        // 捕获信号
        ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], function ($signal) {
            $this->log->info('Received signal [{signal}]', ['signal' => $signal]);
            $this->log->info('Server shutdown');
            $this->registry->close();
            $this->config->close();
            $this->server->shutdown();
            ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], null);
        });
        // 监听配置
        /** @var $dispatcher EventDispatcher */
        $dispatcher = context()->get('event');
        $this->config->listen($dispatcher);
        // 初始化
        $this->init();
        // 启动服务器
        $this->start();
    }

    /**
     * Init
     */
    abstract public function init();

    /**
     * 启动服务器
     * @throws \Swoole\Exception
     * @throws \Exception
     */
    public function start()
    {
        $this->welcome();
        // 服务注册
        $timer = Timer::new();
        $timer->tick(100, function () use ($timer) {
            if (!$this->server->port) {
                return;
            }
            xdefer(function () use ($timer) {
                $timer->clear();
            });
            $serviceFactory = new ServiceFactory();
            $services       = $serviceFactory->createServiceFromGrpc($this->server);
            $this->log->info(sprintf('Server started [%s:%d]', $this->server->host, $this->server->port));
            foreach ($services as $service) {
                $this->log->info(sprintf('Register service [%s]', $service->getID()));
            }
            $this->registry->register(...$services);
        });
        // 启动
        $this->server->start();
    }

    /**
     * 欢迎信息
     */
    protected function welcome()
    {
        $phpVersion    = PHP_VERSION;
        $swooleVersion = swoole_version();
        echo <<<EOL
                              ____
 ______ ___ _____ ___   _____  / /_ _____
  / __ `__ \/ /\ \/ /__ / __ \/ __ \/ __ \
 / / / / / / / /\ \/ _ / /_/ / / / / /_/ /
/_/ /_/ /_/_/ /_/\_\  / .___/_/ /_/ .___/
                     /_/         /_/


EOL;
        println('Server         Name:      mix-grpc');
        println('System         Name:      ' . strtolower(PHP_OS));
        println("PHP            Version:   {$phpVersion}");
        println("Swoole         Version:   {$swooleVersion}");
        println('Framework      Version:   ' . \Mix::$version);
    }

}
