<?php

return [

    // 服务中心
    [
        // 作用域
        'scope'      => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'      => \Mix\Etcd\Registry::class,
        // 初始方法
        'initMethod' => 'init',
        // 属性注入
        'properties' => [
            // 主机
            'host'     => '127.0.0.1',
            // 端口
            'port'     => 2379,
            // 用户
            'user'     => 'test',
            // 密码
            'password' => '123456',
            // 生存时间 (服务注册)
            'ttl'      => 5,
            // 空闲时间 (服务发现)
            'idle'     => 30,
        ],
    ],

    // 配置中心
    [
        // 作用域
        'scope'      => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'      => \Mix\Etcd\Config::class,
        // 初始方法
        'initMethod' => 'init',
        // 属性注入
        'properties' => [
            // 主机
            'host'       => '127.0.0.1',
            // 端口
            'port'       => 2379,
            // 用户
            'user'       => 'test',
            // 密码
            'password'   => '123456',
            // 刷新间隔
            'interval'   => 5,
            // 名称空间
            'namespaces' => [
                '/mix/app',
            ],
            // 事件调度器
            'dispatcher' => ['ref' => 'event'],
        ],
    ],

];
