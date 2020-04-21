<?php

namespace App\Api\Commands;

/**
 * Class GreeterCommand
 * @package App\Api\Commands
 */
class GreeterCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 路由配置
        $this->route
            ->rule('/greeter/say/hello', [
                [\App\Api\Controllers\Greeter\SayController::class, 'hello'],
                'middleware' => [\App\Api\Middleware\ActionMiddleware::class],
            ])
            ->rule('/greeter/carry/luggage', [
                [\App\Api\Controllers\Greeter\CarryController::class, 'luggage'],
                'middleware' => [\App\Api\Middleware\ActionMiddleware::class],
            ])
            ->parse();
    }

}