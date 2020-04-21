<?php

namespace App\Api\Commands;

/**
 * Class FileCommand
 * @package App\Api\Commands
 */
class FileCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 路由配置
        $this->route
            ->rule('POST /file/upload', [
                [\App\Api\Controllers\FileController::class, 'upload'],
                'middleware' => [\App\Api\Middleware\ActionMiddleware::class],
            ])
            ->parse();
    }

}