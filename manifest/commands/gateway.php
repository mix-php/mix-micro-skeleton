<?php

return [

    'gw:start' => [
        \App\Gateway\Commands\StartCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
            [['r', 'reuse-port'], 'description' => "Reuse port in multiple processes"],
            [['p', 'proxy'], 'description' => "Started server name"],
        ],
    ],

];
