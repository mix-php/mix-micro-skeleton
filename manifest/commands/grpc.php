<?php

return [

    'grpc:greeter' => [
        \App\Grpc\Commands\GreeterCommand::class,
        'usage'   => "\tStart a micro service",
        'options' => [
            [['d', 'daemon'], 'usage' => "Run in the background"],
        ],
    ],

    'grpc:curl' => [
        \App\Grpc\Commands\CurlCommand::class,
        'usage'   => "\tStart a micro service",
        'options' => [
            [['d', 'daemon'], 'usage' => "Run in the background"],
        ],
    ],

    'grpc:user' => [
        \App\Grpc\Commands\UserCommand::class,
        'usage'   => "\tStart a micro service",
        'options' => [
            [['d', 'daemon'], 'usage' => "Run in the background"],
        ],
    ],

];
