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
        // 属性注入
        'properties' => [
            // 代理的命名空间
            'namespace'    => 'php.micro.api',
            // 服务注册器
            'registry'     => ['ref' => \Mix\Etcd\Registry::class],
            // 代理超时
            'proxyTimeout' => 30.0,
            // 日志
            'log'          => ['ref' => 'log'],
            // 日志格式
            'logFormat'    => '{status} | {uri} | {service}',
        ],
    ],



];
