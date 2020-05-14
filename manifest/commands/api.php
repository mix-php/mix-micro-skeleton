<?php

return [

    'api:greeter' => [
        \App\Api\Commands\GreeterCommand::class,
        'usage'   => "\tStart a micro service",
        'options' => [
            [['d', 'daemon'], 'usage' => "Run in the background"],
        ],
    ],

    'api:user' => [
        \App\Api\Commands\UserCommand::class,
        'usage'   => "\tStart a micro service",
        'options' => [
            [['d', 'daemon'], 'usage' => "Run in the background"],
        ],
    ],

];
