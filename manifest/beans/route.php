<?php

return [

    // Api路由
    [
        // 名称
        'name'            => 'apiRouter',
        // 类路径
        'class'           => \App\Api\Route\Router::class,
        // 构造函数注入
        'constructorArgs' => [
            // routeDefinitionCallback
            null,
            // middleware
            [\App\Api\Middleware\TracingApiServerMiddleware::class, \App\Api\Middleware\GlobalMiddleware::class],
        ],
    ],

    // Web路由
    [
        // 名称
        'name'            => 'webRouter',
        // 类路径
        'class'           => \App\Api\Route\Router::class,
        // 构造函数注入
        'constructorArgs' => [
            // routeDefinitionCallback
            null,
            // middleware
            [\App\Web\Middleware\TracingWebServerMiddleware::class, \App\Web\Middleware\GlobalMiddleware::class],
        ],
    ],

];
