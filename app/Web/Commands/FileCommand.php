<?php

namespace App\Web\Commands;

use Mix\FastRoute\RouteCollector;

/**
 * Class FileCommand
 * @package App\Web\Commands
 */
class FileCommand extends StartCommand
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
        $collector->post('/file/upload',
            [\App\Web\Controllers\FileController::class, 'upload'],
            [\App\Web\Middleware\ActionMiddleware::class]
        );
    }

}