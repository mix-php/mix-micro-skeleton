<?php

namespace App\Gateway\Commands;

use Mix\Console\CommandLine\Flag;
use Mix\Helper\ProcessHelper;
use Mix\Log\Logger;
use Mix\Micro\Gateway\Server;

/**
 * Class StartCommand
 * @package App\Gateway\Commands
 */
class StartCommand
{

    /**
     * @var Server
     */
    public $server;

    /**
     * @var Logger
     */
    public $log;

    /**
     * StartCommand constructor.
     */
    public function __construct()
    {
        $this->log = context()->get('log');

        $this->log->withName('GATEWAY');
        /** @var \Monolog\Handler\HandlerInterface $handler */
        $handler = context()->get('gatewayRotatingFileHandler');
        $this->log->pushHandler($handler);
    }

    /**
     * 主函数
     * @throws \Swoole\Exception
     */
    public function main()
    {
        // 参数重写
        $proxy = Flag::string(['p', 'proxy'], 'web');
        switch ($proxy) {
            case 'web':
                $serverName = 'webGatewayServer';
                break;
            case 'api':
                $serverName = 'apiGatewayServer';
                break;
            case 'rpc':
                $serverName = 'rpcGatewayServer';
                break;
            default:
                $serverName = 'webGatewayServer';
        }
        $this->server = context()->get($serverName);
        $reusePort    = Flag::bool(['r', 'reuse-port'], false);
        if ($reusePort) {
            $this->server->reusePort = $reusePort;
        }
        // 捕获信号
        ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], function ($signal) {
            $this->log->info('Received signal [{signal}]', ['signal' => $signal]);
            $this->log->info('Server shutdown');
            $this->server->shutdown();
            ProcessHelper::signal([SIGINT, SIGTERM, SIGQUIT], null);
        });
        // 启动服务器
        $this->start();
    }

    /**
     * 启动服务器
     * @throws \Swoole\Exception
     */
    public function start()
    {
        $this->welcome();
        $this->log->info('Server start');
        $this->server->start();
    }

    /**
     * 欢迎信息
     */
    protected function welcome()
    {
        $phpVersion    = PHP_VERSION;
        $swooleVersion = swoole_version();
        $port          = $this->server->port;
        echo <<<EOL
                              ____
 ______ ___ _____ ___   _____  / /_ _____
  / __ `__ \/ /\ \/ /__ / __ \/ __ \/ __ \
 / / / / / / / /\ \/ _ / /_/ / / / / /_/ /
/_/ /_/ /_/_/ /_/\_\  / .___/_/ /_/ .___/
                     /_/         /_/


EOL;
        println('Server         Name:      mix-gateway');
        println('System         Name:      ' . strtolower(PHP_OS));
        println("PHP            Version:   {$phpVersion}");
        println("Swoole         Version:   {$swooleVersion}");
        println('Framework      Version:   ' . \Mix::$version);
        println("Listen         Port:      {$port}");
    }

}
