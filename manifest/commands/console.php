<?php

return [

    'conf:sync' => [
        \App\Console\Commands\ConfigSyncCommand::class,
        'usage'   => "Sync config to config-server",
        'options' => [
        ],
    ],

];
