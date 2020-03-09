<?php

namespace App\Api\Controllers;

use Common\Helpers\ResponseHelper;
use Mix\Http\Message\ServerRequest;
use Mix\Http\Message\Response;

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
     * @return Response
     */
    public function sayHello(ServerRequest $request, Response $response)
    {
        $data = [
            'code'    => 0,
            'message' => sprintf('hello, %s', $request->getAttribute('name', '?')),
        ];
        return ResponseHelper::json($response, $data);
    }

}
