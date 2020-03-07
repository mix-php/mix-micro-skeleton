<?php

return [

    'gw:start' => [
        \App\Gateway\Commands\StartCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
            [['p', 'port'], 'description' => "\tListen to the specified port"],
            [['r', 'reuse-port'], 'description' => "Reuse port in multiple processes"],
        ],
    ],

];
