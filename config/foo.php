<?php

/**
 * 同步到配置中心的配置信息
 * key/value 只能为 string 类型
 */

return [
    '/app_debug' => '1',
    '/database'  => json_encode([
        'dsn'      => 'mysql:host=127.0.0.1;port=3306;charset=utf8;dbname=test',
        'username' => 'root',
        'password' => '',
    ]),
    '/redis'     => json_encode([
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'database' => 0,
        'password' => '',
    ]),
];
