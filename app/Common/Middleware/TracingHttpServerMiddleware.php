<?php

namespace App\Common\Middleware;

use Mix\Micro\Register\Helper\ServiceHelper;
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
     * @throws \PhpDocReader\AnnotationException
     * @throws \ReflectionException
     */
    public function tracer()
    {
        /** @var \Mix\Zipkin\Tracing $tracing */
        $tracing = context()->get(Tracing::class);
        return $tracing->trace('Http', ServiceHelper::localIP());
    }

}