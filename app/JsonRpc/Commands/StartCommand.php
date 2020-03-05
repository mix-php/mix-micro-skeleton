<?php

namespace App\JsonRpc\Commands;

use Mix\Console\CommandLine\Flag;
use Mix\Etcd\Factory\ServiceBundleFactory;
use Mix\Etcd\Factory\ServiceFactory;
use Mix\Etcd\Registry;
use Mix\Helper\ProcessHelper;
use Mix\Log\Logger;
use Mix\JsonRpc\Server;
use Mix\Micro\Helper\ServiceHelper;

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
        $tcpPort = Flag::string(['p', 'tcp-port'], '');
        if ($tcpPort) {
            $this->server->port = $tcpPort;
        }
        // 捕获信号
        ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], function ($signal) {
            $this->log->info('received signal [{signal}]', ['signal' => $signal]);
            $this->log->info('server shutdown');
            $this->server->shutdown();
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
        $serviceFactory = new ServiceFactory();
        $serviceBundle  = (new ServiceBundleFactory())->createServiceBundle();
        foreach ($this->services as $class) {
            $suffix  = strtolower(basename(str_replace('\\', '/', $class)));
            $name    = sprintf('php.micro.srv.%s', $suffix);
            $service = $serviceFactory->createJsonRpcService(
                $name,
                ServiceHelper::localIP(),
                $this->server->port
            );
            $serviceBundle->add($service);
            $this->server->register(new $class);
        }
        $this->registry->register($serviceBundle);
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
        println('Server         Name:      mix-jsonrpcd');
        println('System         Name:      ' . strtolower(PHP_OS));
        println("PHP            Version:   {$phpVersion}");
        println("Swoole         Version:   {$swooleVersion}");
        println('Framework      Version:   ' . \Mix::$version);
        println("Listen         Addr:      {$host}");
        println("Listen         Port:      {$port}");
    }

}