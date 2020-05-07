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
                case '/mix/app/app_debug':
                    app()->appDebug = (bool)$event->value;
                    break;
                case '/mix/app/database':
                    $info       = json_decode($event->value, true);
                    $definition = context()->getBeanDefinition('database');
                    foreach ($info as $key => $value) {
                        $definition->withPropertie($key, $value);
                    }
                    $definition->refresh();
                case '/mix/app/redis':
                    $info       = json_decode($event->value, true);
                    $definition = context()->getBeanDefinition('redis');
                    foreach ($info as $key => $value) {
                        $definition->withPropertie($key, $value);
                    }
                    $definition->refresh();
            }
        }
    }

}
