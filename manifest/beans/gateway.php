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
            // 处理器
            'handler' => ['ref' => \Mix\Micro\Gateway\Handler::class],
        ],
    ],

    // Gateway处理器
    [
        // 类路径
        'class'      => \Mix\Micro\Gateway\Handler::class,
        // 初始方法
        'initMethod' => 'init',
        // 属性注入
        'properties' => [
            // 代理的命名空间
            'namespaces'   => ['ref' => \Mix\Micro\Gateway\Namespaces::class],
            // 服务注册器
            'registry'     => ['ref' => \Mix\Etcd\Registry::class],
            // 代理超时
            'proxyTimeout' => 30.0,
            // 事件调度器
            'dispatcher'   => ['ref' => 'event'],
        ],
    ],

    // 代理的命名空间
    [
        // 类路径
        'class'      => \Mix\Micro\Gateway\Namespaces::class,
        // 属性注入
        'properties' => [
            // api
            'api'     => 'php.micro.api',
            // web
            'web'     => 'php.micro.web',
            // jsonrpc
            'jsonrpc' => 'php.micro.srv.jsonrpc',
        ],
    ],

];
