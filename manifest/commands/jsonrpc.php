<?php

return [

    'jrpc:greeter:start' => [
        \App\JsonRpc\Commands\GreeterCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

    'jrpc:curl:start' => [
        \App\JsonRpc\Commands\CurlCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

    'jrpc:user:start' => [
        \App\JsonRpc\Commands\UserCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

];
