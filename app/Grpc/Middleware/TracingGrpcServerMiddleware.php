<?php

namespace App\Grpc\Middleware;

use Mix\Micro\Register\Helper\ServiceHelper;
use Mix\Tracing\Grpc\TracingServerMiddleware;
use Mix\Tracing\Zipkin\Tracing;

/**
 * Class TracingGrpcServerMiddleware
 * @package App\Grpc\Middleware
 */
class TracingGrpcServerMiddleware extends TracingServerMiddleware
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