<?php

return [

    // JsonRpc拨号器
    [
        // 类路径
        'class'      => \Mix\JsonRpc\Client\Dialer::class,
        // 属性注入
        'properties' => [
            // 注册中心
            'registry' => ['ref' => \Mix\Etcd\Registry::class],
        ],
    ],

    // JsonRpc服务器
    [
        // 类路径
        'class'           => \Mix\JsonRpc\Server::class,
        // 构造函数注入
        'constructorArgs' => [
            // host
            '0.0.0.0',
            // port
            9506,
        ],
        // 属性注入
        'properties'      => [
            // 事件调度器
            'dispatcher' => ['ref' => 'event'],
            // 中间件
            'middleware' => [\App\JsonRpc\Middleware\TracingJsonRpcServerMiddleware::class],
        ],
    ],

];
