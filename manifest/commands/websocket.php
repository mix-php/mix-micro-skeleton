<?php

return [

    'web:webscoket:start' => [
        \App\WebSocket\Commands\WebSocketCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

];
