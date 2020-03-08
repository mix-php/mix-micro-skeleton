<?php

return [

    // 路由
    [
        // 名称
        'name'       => 'apiRoute',
        // 类路径
        'class'      => \Mix\Route\Router::class,
        // 初始方法
        'initMethod' => 'parse',
        // 属性注入
        'properties' => [
            // 默认变量规则
            'defaultPattern' => '[\w-]+',
            // 路由变量规则
            'patterns'       => [
                'id' => '\d+',
            ],
            // 全局中间件
            'middleware'     => [\App\Api\Middleware\GlobalMiddleware::class],
            // 路由规则
            'rules'          => [

                '/greeter/say/hello' => [[\App\Api\Controllers\GreeterController::class, 'sayHello'], 'middleware' => [\App\Api\Middleware\ActionMiddleware::class]],

            ],
        ],
    ],

];
