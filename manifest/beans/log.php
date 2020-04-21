<?php

return [

    // 日志
    [
        // 名称
        'name'            => 'log',
        // 作用域
        'scope'           => \Mix\Bean\BeanDefinition::SINGLETON,
        // 类路径
        'class'           => \Mix\Log\Logger::class,
        // 构造函数注入
        'constructorArgs' => [
            // name
            'MIX',
            // handlers
            [new \Mix\Log\Handler\ConsoleHandler],
            // processors
            [new \Monolog\Processor\PsrLogMessageProcessor],
        ],
    ],

];
