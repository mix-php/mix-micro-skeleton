<?php

namespace App\JsonRpc\Commands;

use Mix\Console\CommandLine\Flag;
use Mix\Etcd\Factory\ServiceBundleFactory;
use Mix\Etcd\Factory\ServiceFactory;
use Mix\Etcd\ServiceCenter;
use Mix\Helper\ProcessHelper;
use Mix\Log\Logger;
use Mix\JsonRpc\Server;
use Mix\ServiceCenter\Helper\ServiceHelper;

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
    public $rpcServer;

    /**
     * @var ServiceCenter
     */
    public $serviceCenter;

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
        $this->log           = context()->get('log');
        $this->rpcServer     = context()->get(Server::class);
        $this->serviceCenter = context()->get(ServiceCenter::class);
    }

    /**
     * 主函数
     */
    public function main()
    {
        // 参数重写
        $host = Flag::string(['h', 'host'], '');
        if ($host) {
            $this->rpcServer->host = $host;
        }
        $tcpPort = Flag::string(['p', 'tcp-port'], '');
        if ($tcpPort) {
            $this->rpcServer->port = $tcpPort;
        }
        // 捕获信号
        ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], function ($signal) {
            $this->log->info('received signal [{signal}]', ['signal' => $signal]);
            $this->log->info('server shutdown');
            $this->rpcServer->shutdown();
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
            $className = strtolower(basename(str_replace('\\', '/', $class)));
            $name      = sprintf('php.micro.srv.%s', $className);
            $service   = $serviceFactory->createService(
                $name,
                ServiceHelper::localIP(),
                $this->rpcServer->port
            );
            $serviceBundle->add($service);
            $this->rpcServer->register(new $class);
        }
        $this->serviceCenter->register($serviceBundle);
        $this->rpcServer->start();
    }

    /**
     * 欢迎信息
     */
    protected function welcome()
    {
        $phpVersion    = PHP_VERSION;
        $swooleVersion = swoole_version();
        $host          = $this->rpcServer->host;
        $tcpPort       = $this->rpcServer->port;
        $httpPort      = $this->httpServer->port;
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
        println("TCP            Port:      {$tcpPort}");
        println("HTTP           Port:      {$httpPort}");
    }

}
