<?php

namespace App\Api\Commands;

use Mix\FastRoute\RouteCollector;

/**
 * Class UserCommand
 * @package App\Api\Commands
 */
class UserCommand extends StartCommand
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
        $collector->group('/greeter/say/hello',
            function (RouteCollector $collector) {
                $collector->post('/user/create',
                    [\App\Api\Controllers\UserController::class, 'create'],
                    [\App\Api\Middleware\ActionMiddleware::class]
                );
            },
            [\App\Api\Middleware\GroupMiddleware::class]
        );
    }

}