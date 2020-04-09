<?php

namespace App\Common\Middleware;

use Mix\Micro\Register\Helper\ServiceHelper;
use Mix\Zipkin\Middleware\JsonRpc\TracingServerMiddleware;
use Mix\Zipkin\Tracing;

/**
 * Class TracingJsonRpcServerMiddleware
 * @package App\Common\Middleware
 */
class TracingJsonRpcServerMiddleware extends TracingServerMiddleware
{

    /**
     * Get tracer
     * @return \OpenTracing\Tracer
     * @throws \PhpDocReader\AnnotationException
     * @throws \ReflectionException
     */
    public function tracer()
    {
        /** @var \Mix\Zipkin\Tracing $tracing */
        $tracing = context()->get(Tracing::class);
        return $tracing->startTracer('JsonRpc', ServiceHelper::localIP());
    }

}