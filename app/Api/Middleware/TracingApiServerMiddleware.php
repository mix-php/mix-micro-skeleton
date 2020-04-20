<?php

namespace App\Api\Middleware;

use Mix\Micro\Register\Helper\ServiceHelper;
use Mix\Tracing\\Http\TracingServerMiddleware;
use Mix\Zipkin\Tracing;

/**
 * Class TracingApiServerMiddleware
 * @package App\Api\Middleware
 */
class TracingApiServerMiddleware extends TracingServerMiddleware
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
        return $tracing->startTracer('API', ServiceHelper::localIP());
    }

}