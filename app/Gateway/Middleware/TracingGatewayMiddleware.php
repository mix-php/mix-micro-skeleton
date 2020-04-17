<?php

namespace App\Gateway\Middleware;

use Mix\Micro\Register\Helper\ServiceHelper;
use Mix\Tracing\Middleware\Http\TracingServerMiddleware;
use Mix\Zipkin\Tracing;

/**
 * Class TracingGatewayMiddleware
 * @package App\Gateway\Middleware
 */
class TracingGatewayMiddleware extends TracingServerMiddleware
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
        return $tracing->startTracer('Gateway', ServiceHelper::localIP());
    }

}