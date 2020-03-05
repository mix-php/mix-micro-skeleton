<?php

return [

    // SyncInvoke连接池
    [
        // 名称
        'name'       => 'syncInvokePool',
        // 作用域
        'scope'      => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'      => \Mix\SyncInvoke\Pool\ConnectionPool::class,
        // 属性注入
        'properties' => [
            // 最多可空闲连接数
            'maxIdle'         => 5,
            // 最大连接数
            'maxActive'       => 50,
            // 拨号器
            'dialer'          => ['ref' => \Mix\SyncInvoke\Pool\Dialer::class],
            // 事件调度器
            'eventDispatcher' => ['ref' => 'event'],
        ],
    ],

    // SyncInvoke连接池拨号器
    [
        // 类路径
        'class'      => \Mix\SyncInvoke\Pool\Dialer::class,
        // 属性注入
        'properties' => [
            // port
            'port' => 9505,
        ],
    ],

    // SyncInvoke客户端
    [
        // 类路径
        'class'      => \Mix\SyncInvoke\Client::class,
        // 属性注入
        'properties' => [
            // 连接池
            'pool' => ['ref' => 'syncInvokePool'],
        ],
    ],

    // SyncInvoke服务器
    [
        // 名称
        'name'            => 'syncInvokeServer',
        // 类路径
        'class'           => \Mix\SyncInvoke\Server::class,
        // 构造函数注入
        'constructorArgs' => [
            // port
            9505,
        ],
    ],

];
