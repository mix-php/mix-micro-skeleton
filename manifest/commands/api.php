<?php

return [

    'api:greeter:start' => [
        \App\Api\Commands\GreeterCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

    'api:user:start' => [
        \App\Api\Commands\UserCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

];
