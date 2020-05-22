<?php

return [

    // JsonRpc服务器
    [
        // 类路径
        'class'           => \Mix\JsonRpc\Server::class,
        // 属性注入
        'properties'      => [
            // 事件调度器
            'dispatcher' => ['ref' => 'dispatcher'],
            // 中间件
            'middleware' => [\App\JsonRpc\Middleware\TracingJsonRpcServerMiddleware::class],
        ],
    ],

    // JsonRpc客户端
    [
        // 类路径
        'class'      => \Mix\JsonRpc\Client\Dialer::class,
        // 属性注入
        'properties' => [
            // 注册中心
            'registry' => ['ref' => \Mix\Micro\Etcd\Registry::class],
        ],
    ],

];
