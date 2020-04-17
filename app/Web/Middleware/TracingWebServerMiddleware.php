<?php

namespace App\Web\Middleware;

use Mix\Micro\Register\Helper\ServiceHelper;
use Mix\Tracing\Middleware\Http\TracingServerMiddleware;
use Mix\Zipkin\Tracing;

/**
 * Class TracingWebServerMiddleware
 * @package App\Web\Middleware
 */
class TracingWebServerMiddleware extends TracingServerMiddleware
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
        return $tracing->startTracer('WEB', ServiceHelper::localIP());
    }

}