<?php

namespace App\Api\Commands;

use App\Api\Route\Router;
use Mix\Micro\Micro;
use Mix\Monolog\Logger;
use Mix\Monolog\Handler\RotatingFileHandler;
use Mix\Micro\Etcd\Configurator;
use Mix\Micro\Etcd\Registry;
use Mix\Helper\ProcessHelper;
use Mix\Http\Server\Server;

/**
 * Class StartCommand
 * @package App\Api\Commands
 * @author liu,jian <coder.keda@gmail.com>
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
    public $logger;

    /**
     * @var Router
     */
    public $router;

    /**
     * StartCommand constructor.
     */
    public function __construct()
    {
        $this->logger   = context()->get('log');
        $this->router   = context()->get('apiRouter');
        $this->server   = context()->get(Server::class);
        $this->config   = context()->get(Configurator::class);
        $this->registry = context()->get(Registry::class);
        // 设置日志处理器
        $this->logger->withName('API');
        $handler = new RotatingFileHandler(sprintf('%s/runtime/logs/api.log', app()->basePath), 7);
        $this->logger->pushHandler($handler);
    }

    /**
     * 主函数
     * @throws \Swoole\Exception
     */
    public function main()
    {
        // 捕获信号
        ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], function ($signal) {
            $this->logger->info('Received signal [{signal}]', ['signal' => $signal]);
            $this->logger->info('Server shutdown');
            $this->registry->close();
            $this->config->close();
            $this->server->shutdown();
            ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], null);
        });
        // 监听配置
        $this->config->listen();
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
        // Run
        Micro::service(
            Micro::name('php.micro.api'),
            Micro::server($this->server),
            Micro::router($this->router),
            Micro::registry($this->registry),
            Micro::logger($this->logger),
            Micro::version('latest'),
            Micro::metadata(['foo' => 'bar'])
        )->run();
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
        println('Server         Name:      mix-api');
        println('System         Name:      ' . strtolower(PHP_OS));
        println("PHP            Version:   {$phpVersion}");
        println("Swoole         Version:   {$swooleVersion}");
        println('Framework      Version:   ' . \Mix::$version);
    }

}
