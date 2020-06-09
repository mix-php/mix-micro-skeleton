<?php

namespace App\Web\Commands;

use Mix\FastRoute\RouteCollector;

/**
 * Class IndexCommand
 * @package App\Web\Commands
 */
class IndexCommand extends StartCommand
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
        $collector->get('/index',
            [\App\Web\Controllers\IndexController::class, 'index'],
            [\App\Web\Middleware\ActionMiddleware::class]
        );
    }

}