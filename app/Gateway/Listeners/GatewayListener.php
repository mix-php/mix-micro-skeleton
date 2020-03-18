<?php

namespace App\Gateway\Listeners;

use Mix\Event\ListenerInterface;
use Mix\Micro\Gateway\Event\AccessEvent;
use Mix\Micro\Gateway\Helper\ProxyHelper;
use Psr\Log\LoggerInterface;

/**
 * Class GatewayListener
 * @package App\Gateway\Listeners
 * @author liu,jian <coder.keda@gmail.com>
 */
class GatewayListener implements ListenerInterface
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
            AccessEvent::class,
        ];
    }

    /**
     * 处理事件
     * @param object $event
     */
    public function process(object $event)
    {
        // 事件触发后，会执行该方法
        if (!$event instanceof AccessEvent) {
            return;
        }
        $level   = $event->status != 200 || $event->error ? 'warning' : 'info';
        $message = '{time}|{status}|{method}|{protocol}|{request_uri}|{service}|{error}';
        $service = $event->service;
        $context = [
            'time'        => $event->time,
            'status'      => $event->status,
            'method'      => $event->request->getMethod(),
            'protocol'    => ProxyHelper::isWebSocket($event->request) ? 'WS' : 'HTTP',
            'request_uri' => ProxyHelper::getRequestUri($event->request->getUri()),
            'service'     => $service ? sprintf('service:%s,addr:%s:%s', $service->getName(), $service->getAddress(), $service->getPort()) : '',
            'error'       => $event->error,
        ];
        $this->log->log($level, $message, $context);
    }

}
