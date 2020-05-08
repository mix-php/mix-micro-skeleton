<?php

return [

    'web:index' => [
        \App\Web\Commands\IndexCommand::class,
        'usage' => "\tStart a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "Run in the background"],
        ],
    ],

    'web:file' => [
        \App\Web\Commands\FileCommand::class,
        'usage' => "\tStart a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "Run in the background"],
        ],
    ],

    'web:profile' => [
        \App\Web\Commands\ProfileCommand::class,
        'usage' => "\tStart a micro service",
        'options'     => [
            [['d', 'daemon'], 'usage' => "Run in the background"],
        ],
    ],

];
