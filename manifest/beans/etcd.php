<?php

return [

    // 服务中心
    [
        // 类路径
        'class'      => \Mix\Etcd\ServiceCenter::class,
        // 属性注入
        'properties' => [
            // 主机
            'host' => '127.0.0.1',
            // 端口
            'port' => 2379,
            // 生存时间
            'ttl'  => 10,
        ],
    ],

];
