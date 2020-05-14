<?php

namespace App\Api\Commands;

/**
 * Class UserCommand
 * @package App\Api\Commands
 */
class UserCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 路由配置
        $this->route
            ->rule('/v2', [
                // 分组路由规则
                [
                    // 分组路由
                    'POST /user/create' => [
                        [\App\Api\Controllers\UserController::class, 'create'],
                        'middleware' => [\App\Api\Middleware\ActionMiddleware::class],
                    ],
                ],
                // 分组中间件
                'middleware' => [\App\Api\Middleware\GroupMiddleware::class],
            ])
            ->parse();
    }

}