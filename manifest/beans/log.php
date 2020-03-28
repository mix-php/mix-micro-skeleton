<?php

return [

    // 日志
    [
        // 名称
        'name'       => 'log',
        // 作用域
        'scope'      => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'      => \Mix\Log\Logger::class,
        // 属性注入
        'properties' => [
            // 日志记录级别
            'levels'  => ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'],
            // 处理器
            'handler' => ['ref' => \Mix\Log\MultiHandler::class],
        ],
    ],

    // 日志处理器
    [
        // 类路径
        'class'           => \Mix\Log\MultiHandler::class,
        // 构造函数注入
        'constructorArgs' => [
            // 标准输出处理器
            ['ref' => \Mix\Log\StdoutHandler::class],
            // 文件处理器
            ['ref' => \Mix\Log\FileHandler::class],
        ],
    ],

    // 日志标准输出处理器
    [
        // 类路径
        'class' => \Mix\Log\StdoutHandler::class,
    ],

    // 日志文件处理器
    [
        // 类路径
        'class'      => \Mix\Log\FileHandler::class,
        // 属性注入
        'properties' => [
            // 日志名称
            'filename'    => realpath(__DIR__ . '/../../runtime') . '/logs/mix.log',
            // 开启轮转
            'rotate'      => true,
            // 最大文件尺寸
            'maxFileSize' => 0,
            // 最大保留天数
            'maxDays'     => 7,
        ],
    ],

];
