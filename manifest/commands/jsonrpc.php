<?php

return [

    'jrpc:start' => [
        \App\JsonRpc\Commands\StartCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

];
