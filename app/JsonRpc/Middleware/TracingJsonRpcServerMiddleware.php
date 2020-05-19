<?php

namespace App\JsonRpc\Middleware;

use Mix\Micro\Register\Helper\ServiceHelper;
use Mix\Tracing\JsonRpc\TracingServerMiddleware;
use Mix\Tracing\Zipkin\Zipkin;

/**
 * Class TracingJsonRpcServerMiddleware
 * @package App\JsonRpc\Middleware
 */
class TracingJsonRpcServerMiddleware extends TracingServerMiddleware
{

    /**
     * Get tracer
     * @param string $serviceName
     * @return \OpenTracing\Tracer
     * @throws \PhpDocReader\AnnotationException
     * @throws \ReflectionException
     */
    public function tracer(string $serviceName)
    {
        /** @var \Mix\Tracing\Zipkin\Zipkin $tracing */
        $tracing = context()->get(Zipkin::class);
        return $tracing->startTracer($serviceName, ServiceHelper::localIP());
    }

}