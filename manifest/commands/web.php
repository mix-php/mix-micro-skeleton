<?php

return [

    'web:index' => [
        \App\Web\Commands\IndexCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'web:file' => [
        \App\Web\Commands\FileCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

    'web:profile' => [
        \App\Web\Commands\ProfileCommand::class,
        'usage' => "Start a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "\tRun in the background"],
        ],
    ],

];
