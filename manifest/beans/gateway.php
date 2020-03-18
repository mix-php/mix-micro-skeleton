<?php

return [

    // Gateway服务器
    [
        // 类路径
        'class'           => \Mix\Micro\Gateway\Server::class,
        // 构造函数注入
        'constructorArgs' => [
            // port
            9595,
            // reusePort
            false,
        ],
        // 属性注入
        'properties'      => [
            // 代理器集合
            'proxies'    => [
                // Web代理
                ['ref' => \Mix\Micro\Gateway\Proxy\WebProxy::class],
                // Api代理
                ['ref' => \Mix\Micro\Gateway\Proxy\ApiProxy::class],
                // Json-rpc代理
                ['ref' => \Mix\Micro\Gateway\Proxy\JsonRpcProxy::class],
            ],
            // 中间件
            'middleware' => [\App\Gateway\Middleware\RateLimitMiddleware::class],
            // 注册中心
            'registry'   => ['ref' => \Mix\Etcd\Registry::class],
            // 事件调度器
            'dispatcher' => ['ref' => 'event'],
        ],
    ],

    // Web代理
    [
        // 类路径
        'class'      => \Mix\Micro\Gateway\Proxy\WebProxy::class,
        // 属性注入
        'properties' => [
            // 命名空间
            'namespace' => 'php.micro.web',
            // 超时
            'timeout'   => 5,
        ],
    ],

    // Api代理
    [
        // 类路径
        'class'      => \Mix\Micro\Gateway\Proxy\ApiProxy::class,
        // 属性注入
        'properties' => [
            // 命名空间
            'namespace' => 'php.micro.api',
            // 超时
            'timeout'   => 5,
        ],
    ],

    // Json-rpc代理
    [
        // 类路径
        'class'      => \Mix\Micro\Gateway\Proxy\JsonRpcProxy::class,
        // 属性注入
        'properties' => [
            // 模式
            'pattern' => '/jsonrpc',
            // 超时
            'timeout' => 5,
        ],
    ],

];
