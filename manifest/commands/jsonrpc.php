<?php

return [

    'jrpc:greeter' => [
        \App\JsonRpc\Commands\GreeterCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'jrpc:curl' => [
        \App\JsonRpc\Commands\CurlCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'jrpc:user' => [
        \App\JsonRpc\Commands\UserCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

];
