<?php

namespace App\JsonRpc\Commands;

use Mix\Micro\Micro;
use Mix\Monolog\Logger;
use Mix\Monolog\Handler\RotatingFileHandler;
use Mix\Micro\Etcd\Config;
use Mix\Micro\Etcd\Registry;
use Mix\JsonRpc\Server;

/**
 * Class StartCommand
 * @package App\JsonRpc\Commands
 */
abstract class StartCommand
{

    /**
     * @var Server
     */
    public $server;

    /**
     * @var Config
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
     * StartCommand constructor.
     */
    public function __construct()
    {
        $this->logger   = context()->get('logger');
        $this->server   = context()->get(Server::class);
        $this->config   = context()->get(Config::class);
        $this->registry = context()->get(Registry::class);

        // 设置日志处理器
        $this->logger->withName('JSONRPC');
        $handler = new RotatingFileHandler(sprintf('%s/runtime/logs/jsonrpc.log', app()->basePath), 7);
        $this->logger->pushHandler($handler);

        // 监听配置
        $this->config->listen();

        // 初始化
        $this->init();
    }

    /**
     * Init
     */
    abstract public function init();

    /**
     * 主函数
     * @throws \Swoole\Exception
     */
    public function main()
    {
        $this->welcome();

        // Run
        Micro::service(
            Micro::server($this->server),
            Micro::registry($this->registry),
            Micro::config($this->config),
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
        println('Server         Name:      micro-jsonrpc');
        println('System         Name:      ' . strtolower(PHP_OS));
        println("PHP            Version:   {$phpVersion}");
        println("Swoole         Version:   {$swooleVersion}");
        println('Framework      Version:   ' . \Mix::$version);
    }

}
