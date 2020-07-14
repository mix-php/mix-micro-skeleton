<?php

// Autoload
require __DIR__ . '/../vendor/autoload.php';

// Run application
(new Mix\Console\Application(require __DIR__ . '/../manifest/manifest.php', 'eventDispatcher', 'error'))->run();
