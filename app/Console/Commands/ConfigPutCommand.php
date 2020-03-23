<?php

namespace App\Console\Commands;

use Mix\Etcd\Config;

/**
 * Class ConfigPutCommand
 * @package App\Console\Commands
 * @author liu,jian <coder.keda@gmail.com>
 */
class ConfigPutCommand
{

    /**
     * @var Config
     */
    public $config;

    /**
     * ConfigPutCommand constructor.
     */
    public function __construct()
    {
        $this->config = context()->get(Config::class);
    }

    /**
     * 主函数
     */
    public function main()
    {
        $config = $this->config;
        // key value 都只可为 string
        $config->put([
            '/mix/app/app_debug' => '1',
            '/mix/app/database'  => json_encode([
                'dsn'      => 'mysql:host=127.0.0.1;port=3306;charset=utf8;dbname=test',
                'username' => 'root',
                'password' => '',
            ]),
            '/mix/app/redis'     => json_encode([
                'host'     => '127.0.0.1',
                'port'     => 6379,
                'database' => 0,
                'password' => '',
            ]),
        ]);
        println('ok');
    }

}
