<?php

return [

    // 事件调度器
    [
        // 名称
        'name'            => 'eventDispatcher',
        // 作用域
        'scope'           => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'           => \Mix\Event\EventDispatcher::class,
        // 构造函数注入
        'constructorArgs' => [
            \App\Common\Listeners\ConfigListener::class,
            \App\Common\Listeners\CommandListener::class,
            \App\Common\Listeners\DatabaseListener::class,
            \App\Common\Listeners\RedisListener::class,
            \App\Common\Listeners\HttpServerListener::class,
            \App\Common\Listeners\JsonRpcServerListener::class,
            \App\Common\Listeners\GrpcServerListener::class,
            \App\Common\Listeners\SyncInvokeServerListener::class,
        ],
    ],

];
