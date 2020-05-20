<?php

namespace App\Web\Commands;

/**
 * Class FileCommand
 * @package App\Web\Commands
 */
class FileCommand extends StartCommand
{

    /**
     * Init
     */
    public function init()
    {
        // 路由配置
        $this->router
            ->rule('POST /file/upload', [
                [\App\Web\Controllers\FileController::class, 'upload'],
                'middleware' => [\App\Api\Middleware\ActionMiddleware::class],
            ])
            ->parse();
    }

}