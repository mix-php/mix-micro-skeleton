<?php

namespace App\Api\Middleware;

use Mix\Micro\Register\Helper\ServiceHelper;
use Mix\Tracing\Http\TracingServerMiddleware;
use Mix\Tracing\Zipkin\Tracing;

/**
 * Class TracingApiServerMiddleware
 * @package App\Api\Middleware
 */
class TracingApiServerMiddleware extends TracingServerMiddleware
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
        /** @var \Mix\Tracing\Zipkin\Tracing $tracing */
        $tracing = context()->get(Tracing::class);
        return $tracing->startTracer($serviceName, ServiceHelper::localIP());
    }

}