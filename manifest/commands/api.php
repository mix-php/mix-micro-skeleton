<?php

return [

    'api:greeter' => [
        \App\Api\Commands\GreeterCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'api:user' => [
        \App\Api\Commands\UserCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

];
