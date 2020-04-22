<?php

return [

    'grpc:greeter:start' => [
        \App\Grpc\Commands\GreeterCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

    'grpc:curl:start' => [
        \App\Grpc\Commands\CurlCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

    'grpc:user:start' => [
        \App\Grpc\Commands\UserCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

];
