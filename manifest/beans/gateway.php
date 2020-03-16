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
                \Mix\Micro\Gateway\Proxy\WebProxy::class,
                \Mix\Micro\Gateway\Proxy\ApiProxy::class,
                \Mix\Micro\Gateway\Proxy\JsonRpcProxy::class,
            ],
            // 注册中心
            'registry'   => ['ref' => \Mix\Etcd\Registry::class],
            // 事件调度器
            'dispatcher' => ['ref' => 'event'],
        ],
    ],

];
