<?php

namespace App\Common\Middleware;

use Mix\Zipkin\Middleware\Http\TracingServerMiddleware;
use Mix\Zipkin\Tracer;
use Mix\Zipkin\Tracing;

/**
 * Class TracingServerMiddleware
 * @package App\Common\Middleware
 */
class TracingHttpServerMiddleware extends TracingServerMiddleware
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