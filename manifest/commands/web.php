<?php

return [

    'web:index:start' => [
        \App\Web\Commands\IndexCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'web:file:start' => [
        \App\Web\Commands\FileCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'web:profile:start' => [
        \App\Web\Commands\ProfileCommand::class,
        'usage' => "Start service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

];
