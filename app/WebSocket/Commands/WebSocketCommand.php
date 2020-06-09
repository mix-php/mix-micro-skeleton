<?php

namespace App\WebSocket\Commands;

use Mix\FastRoute\RouteCollector;
use Mix\Http\Message\Factory\StreamFactory;
use Mix\Http\Message\Response;
use Mix\Http\Message\ServerRequest;

/**
 * Class WebSocketCommand
 * @package App\WebSocket\Commands
 */
class WebSocketCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 路由配置
        $this->router->parse([$this, 'routeDefinition']);
    }

    /**
     * 路由定义
     * @param RouteCollector $collector
     */
    public function routeDefinition(RouteCollector $collector)
    {
        $collector->get('/websocket', [$this, 'handle']);
    }

    /**
     * 请求处理
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     */
    public function handle(ServerRequest $request, Response $response)
    {
        try {
            $conn = $this->upgrader->Upgrade($request, $response);
        } catch (\Throwable $e) {
            $response
                ->withBody((new StreamFactory())->createStream('401 Unauthorized'))
                ->withStatus(401);
            return $response;
        }
        xgo(function () use ($conn) {
            call_user_func(new \App\WebSocket\Handlers\WebSocketHandler($conn));
        });
        return $response;
    }

}
