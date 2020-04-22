<?php

namespace App\Grpc\Services\Greeter;

use Mix\Context\Context;
use Mix\Grpc;
use Php\Micro\Grpc\Greeter\CarryInterface;
use Php\Micro\Grpc\Greeter\Request;
use Php\Micro\Grpc\Greeter\Response;

/**
 * Class CarryService
 * @package App\Grpc\Services\Greeter
 */
class CarryService implements CarryInterface
{

    /**
     * Luggage
     * @param Context $context
     * @param Request $request
     * @return Response
     *
     * @throws Grpc\Exception\InvokeException
     */
    public function Luggage(Context $context, Request $request): Response
    {
        $response = new Response();
        $response->setMsg(sprintf('carry %s', $request->getName()));
        return $response;
    }

}
