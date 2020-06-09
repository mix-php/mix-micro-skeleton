<?php

namespace App\Api\Commands;

use Mix\FastRoute\RouteCollector;

/**
 * Class GreeterCommand
 * @package App\Api\Commands
 */
class GreeterCommand extends StartCommand
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
        $collector->get('/greeter/say/hello',
            [\App\Api\Controllers\Greeter\SayController::class, 'hello'],
            [\App\Api\Middleware\ActionMiddleware::class]
        );
        $collector->get('/greeter/carry/luggage',
            [\App\Api\Controllers\Greeter\CarryController::class, 'luggage'],
            [\App\Api\Middleware\ActionMiddleware::class]
        );
    }

}