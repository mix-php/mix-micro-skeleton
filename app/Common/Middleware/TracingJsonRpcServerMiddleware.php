<?php

namespace App\Common\Middleware;

use Mix\Zipkin\Middleware\JsonRpc\TracingServerMiddleware;
use Mix\Zipkin\Tracer;
use Mix\Zipkin\Tracing;

/**
 * Class TracingJsonRpcServerMiddleware
 * @package App\Common\Middleware
 */
class TracingJsonRpcServerMiddleware extends TracingServerMiddleware
{

    /**
     * Get tracer
     * @return Tracer
     */
    public function tracer()
    {
        return context()->get(Tracing::class);
    }

}