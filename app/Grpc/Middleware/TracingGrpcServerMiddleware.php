<?php

namespace App\Grpc\Middleware;

use Mix\Zipkin\Middleware\Grpc\TracingServerMiddleware;

/**
 * Class TracingGrpcServerMiddleware
 * @package App\Grpc\Middleware
 */
class TracingGrpcServerMiddleware extends TracingServerMiddleware
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
        return $tracing->startTracer('Grpc', ServiceHelper::localIP());
    }

}