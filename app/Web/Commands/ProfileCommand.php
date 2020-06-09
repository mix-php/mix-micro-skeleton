<?php

namespace App\Web\Commands;

use Mix\FastRoute\RouteCollector;

/**
 * Class ProfileCommand
 * @package App\Web\Commands
 */
class ProfileCommand extends StartCommand
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
        $collector->get('/profile/{id:\d+}',
            [\App\Web\Controllers\ProfileController::class, 'index'],
            [\App\Web\Middleware\ActionMiddleware::class]
        );
    }

}