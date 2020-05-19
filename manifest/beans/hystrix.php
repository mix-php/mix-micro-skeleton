<?php

return [

    // 熔断器
    [
        // 作用域
        'scope'           => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'           => \Mix\Micro\Hystrix\CircuitBreaker::class,
        // 构造函数注入
        'constructorArgs' => [
            // command config
            [
                [
                    // 名称
                    'name'                   => 'php.micro',
                    // 超时时间, 单位: 秒
                    'timeout'                => 5,
                    // 最大并发数，超过并发返回错误
                    'maxConcurrentRequests'  => 5,
                    // 请求数量的阀值，用这些数量的请求来计算阀值
                    'requestVolumeThreshold' => 4,
                    // 错误百分比阀值，达到阀值，启动熔断
                    'errorPercentThreshold'  => 25,
                    // 熔断尝试恢复时间, 单位: 秒
                    'sleepWindow'            => 10,
                ],
            ],
        ],
        // 属性注入
        'properties'      => [
            // 事件调度器
            'dispatcher' => ['ref' => 'event'],
        ],
    ],

];
