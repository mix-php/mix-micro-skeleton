<?php

namespace App\Api\Controllers\Greeter;

use App\Common\Helpers\ResponseHelper;
use Mix\Http\Message\ServerRequest;
use Mix\Http\Message\Response;
use Mix\Grpc\Client\Dialer;
use Mix\Tracing\Grpc\TracingClientMiddleware;
use Mix\Tracing\Zipkin\Tracing;
use Php\Micro\Grpc\Greeter\CarryClient;
use Php\Micro\Grpc\Greeter\Request;

/**
 * Class CarryController
 * @package App\Api\Controllers\Greeter
 */
class CarryController
{

    /**
     * @var Dialer
     */
    public $dialer;

    /**
     * CarryController constructor.
     */
    public function __construct()
    {
        $this->dialer = context()->get(Dialer::class);
    }

    /**
     * Luggage
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     * @throws \PhpDocReader\AnnotationException
     * @throws \ReflectionException
     */
    public function luggage(ServerRequest $request, Response $response)
    {
        $name = $request->getAttribute('name', '?');

        // 调用rpc
        $tracer     = Tracing::extract($request->getContext());
        $middleware = new TracingClientMiddleware($tracer);
        /** @var CarryClient $client */
        $client     = $this->dialer->dialFromService('php.micro.grpc.greeter', CarryClient::class, $middleware);
        $rpcRequest = new Request();
        $rpcRequest->setName($name);
        $rpcResponse = $client->Luggage($rpcRequest);

        $data = [
            'code'    => 0,
            'message' => $rpcResponse->getMsg(),
        ];
        return ResponseHelper::json($response, $data);
    }

}
