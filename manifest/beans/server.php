<?php

return [

    // Http服务器
    [
        // 类路径
        'class'           => \Mix\Http\Server\Server::class,
        // 构造函数注入
        'constructorArgs' => [
            // host
            '127.0.0.1',
            // port
            9501,
            // ssl
            false,
        ],
    ],

];
