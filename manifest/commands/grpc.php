<?php

return [

    'grpc:greeter' => [
        \App\Grpc\Commands\GreeterCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'grpc:curl' => [
        \App\Grpc\Commands\CurlCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'grpc:user' => [
        \App\Grpc\Commands\UserCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

];
