<?php

namespace App\Api\Controllers;

use Mix\Http\Message\Cookie\Cookie;
use Mix\Http\Message\ServerRequest;
use Mix\Http\Message\Response;
use Mix\Http\Message\Stream\ContentStream;

/**
 * Class GreeterController
 * @package App\Api\Controllers
 */
class GreeterController
{

    /**
     * FileController constructor.
     * @param ServerRequest $request
     * @param Response $response
     */
    public function __construct(ServerRequest $request, Response $response)
    {
    }

    /**
     * Say Hello
     * @param ServerRequest $request
     * @param Response $response
     * @return mixed
     */
    public function sayHello(ServerRequest $request, Response $response)
    {
        $data = [
            'code'    => 0,
            'message' => sprintf('hello, %s', $request->getAttribute('name', '?')),
        ];
        $body = new ContentStream(json_encode($data));
        $response->withBody($body)
            ->withContentType('application/json', 'utf-8')
            ->withStatus(200);
        return $response;
    }

}
