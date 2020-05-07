<?php

return [

    'si:start' => [
        \App\SyncInvoke\Commands\StartCommand::class,
        'usage' => "\tStart service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
            [['p', 'port'], 'usage' => "\tListen to the specified port"],
            [['r', 'reuse-port'], 'usage' => "Reuse port in multiple processes"],
        ],
    ],

];
