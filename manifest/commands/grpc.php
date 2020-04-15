<?php

return [

    'grpc:start' => [
        \App\Grpc\Commands\StartCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

];
