<?php

return [

    'grpc:greeter:start' => [
        \App\Grpc\Commands\GreeterCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'grpc:curl:start' => [
        \App\Grpc\Commands\CurlCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'grpc:user:start' => [
        \App\Grpc\Commands\UserCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

];
