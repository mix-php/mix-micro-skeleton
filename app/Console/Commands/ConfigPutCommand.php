<?php

namespace App\Console\Commands;

use Mix\Micro\Etcd\Configurator;
use Mix\Log\Logger;

/**
 * Class ConfigPutCommand
 * @package App\Console\Commands
 * @author liu,jian <coder.keda@gmail.com>
 */
class ConfigPutCommand
{

    /**
     * @var Configurator
     */
    public $config;

    /**
     * @var Logger
     */
    public $log;

    /**
     * ConfigPutCommand constructor.
     */
    public function __construct()
    {
        $this->log    = context()->get('log');
        $this->config = context()->get(Configurator::class);

        $this->log->withName('CONSOLE');
        $this->log->pushHandler(context()->get('consoleRotatingFileHandler'));
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
