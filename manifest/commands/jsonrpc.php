<?php

return [

    'jsonrpc:greeter' => [
        \App\JsonRpc\Commands\GreeterCommand::class,
        'usage'   => "Start a micro service",
        'options' => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'jsonrpc:curl' => [
        \App\JsonRpc\Commands\CurlCommand::class,
        'usage'   => "\tStart a micro service",
        'options' => [
            [['d', 'daemon'], 'usage' => "Run in the background"],
        ],
    ],

    'jsonrpc:user' => [
        \App\JsonRpc\Commands\UserCommand::class,
        'usage'   => "\tStart a micro service",
        'options' => [
            [['d', 'daemon'], 'usage' => "Run in the background"],
        ],
    ],

];
