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
            'host'           => '127.0.0.1',
            // 端口
            'port'           => 2379,
            // 用户
            'user'           => 'root',
            // 密码
            'password'       => '',
            // 服务注册生存时间
            'registerTTL'    => 5,
            // 服务监控最大空闲时间
            'monitorMaxIdle' => 30,
            // 负载均衡器
            'loadBalancer'   => ['ref' => \Mix\Etcd\LoadBalancer\RoundRobinBalancer::class],
        ],
    ],

    // 负载均衡器
    [
        'class' => \Mix\Etcd\LoadBalancer\RoundRobinBalancer::class,
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
            'user'       => 'root',
            // 密码
            'password'   => '',
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
