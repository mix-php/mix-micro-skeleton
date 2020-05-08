<?php

return [

    'web:webscoket' => [
        \App\WebSocket\Commands\WebSocketCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

];
