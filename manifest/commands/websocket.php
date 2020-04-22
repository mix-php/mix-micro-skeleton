<?php

return [

    'ws:webscoket:start' => [
        \App\WebSocket\Commands\WebSocketCommand::class,
        'description' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'description' => "\tRun in the background"],
        ],
    ],

];
