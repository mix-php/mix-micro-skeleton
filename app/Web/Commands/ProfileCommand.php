<?php

namespace App\Web\Commands;

/**
 * Class ProfileCommand
 * @package App\Web\Commands
 */
class ProfileCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 路由配置
        $this->route
            ->pattern('id', '[\d]+')
            ->rule('/profile/{id}', [
                [\App\Web\Controllers\ProfileController::class, 'index'],
                'middleware' => [\App\Web\Middleware\ActionMiddleware::class],
            ])
            ->parse();
    }

}