<?php

return [

    // 服务中心
    [
        // 作用域
        'scope'      => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'      => \Mix\Micro\Etcd\Registry::class,
        // 初始方法
        'initMethod' => 'init',
        // 属性注入
        'properties' => [
            // 地址
            'url'            => 'http://127.0.0.1:2379/v3',
            // 超时
            'timeout'        => 5,
            // 用户
            'user'           => '',
            // 密码
            'password'       => '',
            // 服务注册生存时间
            'registerTTL'    => 5,
            // 服务监控最大空闲时间
            'monitorMaxIdle' => 30,
            // 负载均衡器
            'loadBalancer'   => ['ref' => \Mix\Micro\Etcd\LoadBalancer\RoundRobinBalancer::class],
        ],
    ],

    // 负载均衡器
    [
        'class' => \Mix\Micro\Etcd\LoadBalancer\RoundRobinBalancer::class,
    ],

    // 配置中心
    [
        // 作用域
        'scope'      => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'      => \Mix\Micro\Etcd\Configurator::class,
        // 初始方法
        'initMethod' => 'init',
        // 属性注入
        'properties' => [
            // 地址
            'url'        => 'http://127.0.0.1:2379/v3',
            // 超时
            'timeout'    => 5,
            // 用户
            'user'       => '',
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
