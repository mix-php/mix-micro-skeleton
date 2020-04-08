<?php

namespace App\Web\Commands;

use Mix\Console\CommandLine\Flag;
use Mix\Etcd\Configurator;
use Mix\Etcd\Factory\ServiceBundleFactory;
use Mix\Etcd\Registry;
use Mix\Helper\ProcessHelper;
use Mix\Http\Server\Server;
use Mix\Log\Logger;
use Mix\Route\Router;

/**
 * Class StartCommand
 * @package App\Web\Commands
 * @author liu,jian <coder.keda@gmail.com>
 */
class StartCommand
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
     * @var Router
     */
    public $route;

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
        $this->route    = context()->get('webRoute');
        $this->server   = context()->get(Server::class);
        $this->config   = context()->get(Configurator::class);
        $this->registry = context()->get(Registry::class);
    }

    /**
     * 主函数
     * @throws \Swoole\Exception
     */
    public function main()
    {
        // 参数重写
        $host = Flag::string(['h', 'host'], '');
        if ($host) {
            $this->server->host = $host;
        }
        $port = Flag::int(['p', 'port'], 0);
        if ($port) {
            $this->server->port = $port;
        }
        // 捕获信号
        ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], function ($signal) {
            $this->log->info('received signal [{signal}]', ['signal' => $signal]);
            $this->log->info('server shutdown');
            $this->registry->close();
            $this->config->close();
            $this->server->shutdown();
            ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], null);
        });
        // 监听配置
        $this->config->listen();
        // 启动服务器
        $this->start();
    }

    /**
     * 启动服务器
     * @throws \Swoole\Exception
     * @throws \Exception
     */
    public function start()
    {
        $this->welcome();
        $this->log->info('server start');
        // 注册服务
        $serviceBundleFactory = new ServiceBundleFactory();
        $serviceBundle        = $serviceBundleFactory->createServiceBundleFromWeb(
            $this->server,
            $this->route,
            'php.micro.web'
        );
        $this->registry->register($serviceBundle);
        // 启动
        $this->server->start($this->route);
    }

    /**
     * 欢迎信息
     */
    protected function welcome()
    {
        $phpVersion    = PHP_VERSION;
        $swooleVersion = swoole_version();
        $host          = $this->server->host;
        $port          = $this->server->port;
        echo <<<EOL
                              ____
 ______ ___ _____ ___   _____  / /_ _____
  / __ `__ \/ /\ \/ /__ / __ \/ __ \/ __ \
 / / / / / / / /\ \/ _ / /_/ / / / / /_/ /
/_/ /_/ /_/_/ /_/\_\  / .___/_/ /_/ .___/
                     /_/         /_/


EOL;
        println('Server         Name:      mix-web');
        println('System         Name:      ' . strtolower(PHP_OS));
        println("PHP            Version:   {$phpVersion}");
        println("Swoole         Version:   {$swooleVersion}");
        println('Framework      Version:   ' . \Mix::$version);
        println("Listen         Addr:      {$host}");
        println("Listen         Port:      {$port}");
    }

}
