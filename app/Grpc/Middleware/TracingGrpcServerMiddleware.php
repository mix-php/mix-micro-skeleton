<?php

namespace App\Grpc\Middleware;

use Mix\Micro\Register\Helper\ServiceHelper;
use Mix\Tracing\Grpc\TracingServerMiddleware;
use Mix\Tracing\Zipkin\Zipkin;

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
        /** @var \Mix\Tracing\Zipkin\Zipkin $tracing */
        $tracing = context()->get(Zipkin::class);
        return $tracing->startTracer($serviceName, ServiceHelper::localIP());
    }

}