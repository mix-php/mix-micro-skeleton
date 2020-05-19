<?php

namespace App\Common\Listeners;

use Mix\Event\ListenerInterface;
use Mix\Micro\Config\Event\DeleteEvent;
use Mix\Micro\Config\Event\PutEvent;

/**
 * Class ConfigListener
 * @package App\Common\Listeners
 * @author liu,jian <coder.keda@gmail.com>
 */
class ConfigListener implements ListenerInterface
{

    /**
     * 监听的事件
     * @return array
     */
    public function events(): array
    {
        return [
            PutEvent::class,
            DeleteEvent::class,
        ];
    }

    /**
     * 处理事件
     * @param object $event
     */
    public function process(object $event)
    {
        if ($event instanceof PutEvent) {
            switch ($event->key) {
                case '/micro/config/app_debug':
                    app()->appDebug = (bool)$event->value;
                    break;
                case '/micro/config/database':
                    $info            = json_decode($event->value, true);
                    $definition      = context()->getBeanDefinition('database');
                    $constructorArgs = $definition->getConstructorArgs();
                    $definition->withConstructorArgs([
                            $info['dsn'],
                            $info['username'],
                            $info['password'],
                        ] + $constructorArgs);
                    $definition->refresh();
                    break;
                case '/micro/config/redis':
                    $info            = json_decode($event->value, true);
                    $definition      = context()->getBeanDefinition('redis');
                    $constructorArgs = $definition->getConstructorArgs();
                    $definition->withConstructorArgs([
                            $info['host'],
                            $info['port'],
                            $info['password'],
                            $info['database'],
                        ] + $constructorArgs);
                    $definition->refresh();
                    break;
            }
        }
    }

}
