<?php

return [

    // Api路由
    [
        // 名称
        'name'       => 'apiRouter',
        // 类路径
        'class'      => \App\Api\Route\Router::class,
        // 初始方法
        'initMethod' => 'parse',
        // 属性注入
        'properties' => [
            // 默认变量规则
            'defaultPattern' => '[\w-]+',
            // 路由变量规则
            'patterns'       => [
            ],
            // 全局中间件
            'middleware'     => [\App\Api\Middleware\TracingApiServerMiddleware::class, \App\Api\Middleware\GlobalMiddleware::class],
            // 路由规则
            'rules'          => [
            ],
        ],
    ],

    // Web路由
    [
        // 名称
        'name'       => 'webRouter',
        // 类路径
        'class'      => \App\Api\Route\Router::class,
        // 初始方法
        'initMethod' => 'parse',
        // 属性注入
        'properties' => [
            // 默认变量规则
            'defaultPattern' => '[\w-]+',
            // 路由变量规则
            'patterns'       => [
            ],
            // 全局中间件
            'middleware'     => [\App\Web\Middleware\TracingWebServerMiddleware::class, \App\Web\Middleware\GlobalMiddleware::class],
            // 路由规则
            'rules'          => [
            ],
        ],
    ],

];
