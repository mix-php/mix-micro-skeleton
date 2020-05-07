<?php

return [

    'api:greeter:start' => [
        \App\Api\Commands\GreeterCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'api:user:start' => [
        \App\Api\Commands\UserCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

];
