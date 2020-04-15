<?php

namespace App\Grpc\Listeners;

use Mix\Event\ListenerInterface;
use Mix\Grpc\Event\ProcessedEvent;
use Psr\Log\LoggerInterface;

/**
 * Class GrpcListener
 * @package App\Grpc\Listeners
 */
class GrpcListener implements ListenerInterface
{

    /**
     * @var LoggerInterface
     */
    public $log;

    /**
     * JsonRpcListener constructor.
     */
    public function __construct()
    {
        $this->log = context()->get('log');
    }

    /**
     * 监听的事件
     * @return array
     */
    public function events(): array
    {
        // 要监听的事件数组，可监听多个事件
        return [
            ProcessedEvent::class,
        ];
    }

    /**
     * 处理事件
     * @param object $event
     */
    public function process(object $event)
    {
        // 事件触发后，会执行该方法
        if (!$event instanceof ProcessedEvent) {
            return;
        }
        $level   = $event->error ? 'warning' : 'info';
        $message = '{time}|{service}|{method}|{error}';
        $context = [
            'time'    => $event->time,
            'service' => $event->service,
            'method'  => $event->method,
            'error'   => $event->error,
        ];
        $this->log->log($level, $message, $context);
    }

}
