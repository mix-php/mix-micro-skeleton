<?php

return [

    // 服务中心
    [
        // 作用域
        'scope'           => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'           => \Mix\Micro\Etcd\Registry::class,
        // 构造函数注入
        'constructorArgs' => [
            // url
            'http://127.0.0.1:2379/v3',
            // user
            '',
            // password
            '',
            // timeout
            5,
        ],
        // 属性注入
        'properties'      => [
            // 名称空间
            'namespace'    => '/micro/registry',
            // 服务注册生存时间
            'registerTTL'  => 5,
            // 服务监控最大空闲时间
            'maxIdle'      => 30,
            // 负载均衡器
            'loadBalancer' => new \Mix\Micro\Etcd\LoadBalancer\RoundRobinBalancer,
        ],
    ],

    // 配置中心
    [
        // 作用域
        'scope'           => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'           => \Mix\Micro\Etcd\Config::class,
        // 构造函数注入
        'constructorArgs' => [
            // url
            'http://127.0.0.1:2379/v3',
            // user
            '',
            // password
            '',
            // timeout
            5,
        ],
        // 属性注入
        'properties'      => [
            // 名称空间
            'namespace' => '/micro/config',
            // 刷新间隔
            'interval'  => 5,
        ],
    ],

];
