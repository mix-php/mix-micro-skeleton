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
            'handler' => ['ref' => \Mix\Micro\Gateway\Handler::class],
        ],
    ],

    // Gateway处理器
    [
        // 类路径
        'class'      => \Mix\Micro\Gateway\Handler::class,
        // 属性注入
        'properties' => [
            'namespace' => 'php.micro.api',
            'log'       => ['ref' => 'log'],
            'registry'  => ['ref' => \Mix\Etcd\Registry::class],
            'timeout'   => 5.0,
        ],
    ],

];
