<?php

return [

    // zipkin链路追踪
    [
        // 作用域
        'scope'      => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'      => \Mix\Zipkin\Tracing::class,
        // 属性注入
        'properties' => [
            // 地址
            'url'     => 'http://127.0.0.1:9411/api/v2/spans',
            // 超时
            'timeout' => 5,
        ],
    ],

];
