<?php

namespace App\JsonRpc\Commands;

use Mix\Console\CommandLine\Flag;
use Mix\Etcd\Factory\ServiceBundleFactory;
use Mix\Etcd\Registry;
use Mix\Helper\ProcessHelper;
use Mix\Log\Logger;
use Mix\JsonRpc\Server;

/**
 * Class StartCommand
 * @package App\Sync\Commands
 * @author liu,jian <coder.keda@gmail.com>
 */
class StartCommand
{

    /**
     * @var Server
     */
    public $server;

    /**
     * @var Registry
     */
    public $registry;

    /**
     * @var Logger
     */
    public $log;

    /**
     * @var string[]
     */
    public $services = [
        \App\JsonRpc\Services\Foo::class,
    ];

    /**
     * StartCommand constructor.
     */
    public function __construct()
    {
        $this->log      = context()->get('log');
        $this->server   = context()->get(Server::class);
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
        $tcpPort = Flag::string(['p', 'port'], '');
        if ($tcpPort) {
            $this->server->port = $tcpPort;
        }
        // 捕获信号
        ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], function ($signal) {
            $this->log->info('received signal [{signal}]', ['signal' => $signal]);
            $this->log->info('server shutdown');
            $this->server->shutdown();
            $this->registry->clear();
            ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], null);
        });
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
        $serviceBundle        = $serviceBundleFactory->createServiceBundleFromJsonRpc(
            $this->server,
            'php.micro.srv.jsonrpc'
        );
        $this->registry->register($serviceBundle);
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
        println('Server         Name:      mix-jsonrpc');
        println('System         Name:      ' . strtolower(PHP_OS));
        println("PHP            Version:   {$phpVersion}");
        println("Swoole         Version:   {$swooleVersion}");
        println('Framework      Version:   ' . \Mix::$version);
        println("Listen         Addr:      {$host}");
        println("Listen         Port:      {$port}");
    }

}
