<?php

return [

    // 服务中心
    [
        // 类路径
        'class'      => \Mix\Etcd\Registry::class,
        // 属性注入
        'properties' => [
            // 主机
            'host'     => '127.0.0.1',
            // 端口
            'port'     => 2379,
            // 用户
            'user'     => 'root',
            // 密码
            'password' => '',
            // 生存时间 (服务注册)
            'ttl'      => 5,
            // 最大空闲时间 (服务发现)
            'maxIdle'  => 30,
        ],
    ],

];
