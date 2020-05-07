<?php

return [

    'jrpc:greeter:start' => [
        \App\JsonRpc\Commands\GreeterCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'jrpc:curl:start' => [
        \App\JsonRpc\Commands\CurlCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'jrpc:user:start' => [
        \App\JsonRpc\Commands\UserCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

];
