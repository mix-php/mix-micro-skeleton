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

    // 轮转文件处理器
    [
        // 名称
        'name'            => 'apiRotatingFileHandler',
        // 类路径
        'class'           => \Mix\Log\Handler\RotatingFileHandler::class,
        // 构造函数注入
        'constructorArgs' => [
            // filename
            realpath(__DIR__ . '/../../runtime') . '/logs/api.log',
            // maxFiles
            7,
            // minimum level
            \Monolog\Logger::DEBUG,
        ],
    ],

    // 轮转文件处理器
    [
        // 名称
        'name'            => 'consoleRotatingFileHandler',
        // 类路径
        'class'           => \Monolog\Handler\RotatingFileHandler::class,
        // 构造函数注入
        'constructorArgs' => [
            // filename
            realpath(__DIR__ . '/../../runtime') . '/logs/console.log',
            // maxFiles
            7,
            // minimum level
            \Monolog\Logger::DEBUG,
        ],
    ],

    // 轮转文件处理器
    [
        // 名称
        'name'            => 'gatewayRotatingFileHandler',
        // 类路径
        'class'           => \Monolog\Handler\RotatingFileHandler::class,
        // 构造函数注入
        'constructorArgs' => [
            // filename
            realpath(__DIR__ . '/../../runtime') . '/logs/gateway.log',
            // maxFiles
            7,
            // minimum level
            \Monolog\Logger::DEBUG,
        ],
    ],

    // 轮转文件处理器
    [
        // 名称
        'name'            => 'grpcRotatingFileHandler',
        // 类路径
        'class'           => \Monolog\Handler\RotatingFileHandler::class,
        // 构造函数注入
        'constructorArgs' => [
            // filename
            realpath(__DIR__ . '/../../runtime') . '/logs/grpc.log',
            // maxFiles
            7,
            // minimum level
            \Monolog\Logger::DEBUG,
        ],
    ],

    // 轮转文件处理器
    [
        // 名称
        'name'            => 'jsonRpcRotatingFileHandler',
        // 类路径
        'class'           => \Monolog\Handler\RotatingFileHandler::class,
        // 构造函数注入
        'constructorArgs' => [
            // filename
            realpath(__DIR__ . '/../../runtime') . '/logs/jsonrpc.log',
            // maxFiles
            7,
            // minimum level
            \Monolog\Logger::DEBUG,
        ],
    ],

    // 轮转文件处理器
    [
        // 名称
        'name'            => 'syncInvokeRotatingFileHandler',
        // 类路径
        'class'           => \Monolog\Handler\RotatingFileHandler::class,
        // 构造函数注入
        'constructorArgs' => [
            // filename
            realpath(__DIR__ . '/../../runtime') . '/logs/syncinvoke.log',
            // maxFiles
            7,
            // minimum level
            \Monolog\Logger::DEBUG,
        ],
    ],

    // 轮转文件处理器
    [
        // 名称
        'name'            => 'webRotatingFileHandler',
        // 类路径
        'class'           => \Monolog\Handler\RotatingFileHandler::class,
        // 构造函数注入
        'constructorArgs' => [
            // filename
            realpath(__DIR__ . '/../../runtime') . '/logs/web.log',
            // maxFiles
            7,
            // minimum level
            \Monolog\Logger::DEBUG,
        ],
    ],

    // 轮转文件处理器
    [
        // 名称
        'name'            => 'webSocketRotatingFileHandler',
        // 类路径
        'class'           => \Monolog\Handler\RotatingFileHandler::class,
        // 构造函数注入
        'constructorArgs' => [
            // filename
            realpath(__DIR__ . '/../../runtime') . '/logs/websocket.log',
            // maxFiles
            7,
            // minimum level
            \Monolog\Logger::DEBUG,
        ],
    ],

];
