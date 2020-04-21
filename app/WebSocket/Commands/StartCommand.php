<?php

namespace App\WebSocket\Commands;

use Mix\Concurrent\Timer;
use Mix\Micro\Etcd\Configurator;
use Mix\Micro\Etcd\Factory\ServiceFactory;
use Mix\Micro\Etcd\Registry;
use Mix\Helper\ProcessHelper;
use Mix\Http\Message\Factory\StreamFactory;
use Mix\Http\Message\Response;
use Mix\Http\Message\ServerRequest;
use Mix\Log\Logger;
use Mix\Http\Server\Server;
use Mix\WebSocket\Upgrader;

/**
 * Class StartCommand
 * @package App\Tcp\Commands
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
     * @var Registry
     */
    public $registry;

    /**
     * @var Logger
     */
    public $log;

    /**
     * @var Upgrader
     */
    public $upgrader;

    /**
     * @var callable[]
     */
    public $patterns = [
        '/websocket' => \App\WebSocket\Handlers\WebSocketHandler::class,
    ];

    /**
     * StartCommand constructor.
     */
    public function __construct()
    {
        $this->log      = context()->get('log');
        $this->server   = context()->get(Server::class);
        $this->config   = context()->get(Configurator::class);
        $this->registry = context()->get(Registry::class);
        $this->upgrader = new Upgrader();

        $this->log->withName('WEBSOCKET');
        /** @var \Monolog\Handler\HandlerInterface $handler */
        $handler = context()->get('webSocketRotatingFileHandler');
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
            $this->upgrader->destroy();
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
        // 设置处理程序
        foreach (array_keys($this->patterns) as $pattern) {
            $this->server->handle($pattern, [$this, 'handle']);
        }
        // 注册服务
        $timer = Timer::new();
        $timer->tick(100, function () use ($timer) {
            if (!$this->server->port) {
                return;
            }
            xdefer(function () use ($timer) {
                $timer->clear();
            });
            $this->log->info(sprintf('Server started [%s:%d]', $this->server->host, $this->server->port));
            $serviceFactory = new ServiceFactory();
            $services       = $serviceFactory->createServicesFromWeb(
                $this->server,
                null,
                'php.micro.web'
            );
            $this->registry->register(...$services);
            $timer->clear();
        });
        // 启动
        $this->server->start();
    }

    /**
     * 请求处理
     * @param ServerRequest $request
     * @param Response $response
     */
    public function handle(ServerRequest $request, Response $response)
    {
        try {
            $conn = $this->upgrader->Upgrade($request, $response);
        } catch (\Throwable $e) {
            $response
                ->withBody((new StreamFactory())->createStream('401 Unauthorized'))
                ->withStatus(401)
                ->end();
            return;
        }
        $pathinfo = $request->getServerParams()['path_info'] ?: '/';
        $class    = $this->patterns[$pathinfo];
        $callback = new $class($conn);
        call_user_func($callback);
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
        println('Server         Name:      mix-websocket');
        println('System         Name:      ' . strtolower(PHP_OS));
        println("PHP            Version:   {$phpVersion}");
        println("Swoole         Version:   {$swooleVersion}");
        println('Framework      Version:   ' . \Mix::$version);
    }

}
