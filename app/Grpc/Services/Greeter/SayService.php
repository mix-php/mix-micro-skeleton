<?php

namespace App\Grpc\Services\Greeter;

use Mix\Context\Context;
use Php\Micro\Grpc\Greeter\Response;
use Php\Micro\Grpc\Greeter\SayInterface;

/**
 * Class SayService
 * @package App\Grpc\Services\Greeter
 */
class SayService implements SayInterface
{

    /**
     * Hello
     * @param Context $context
     * @param \Php\Micro\Grpc\Greeter\Request $request
     * @return Response
     */
    public function Hello(Context $context, \Php\Micro\Grpc\Greeter\Request $request): Response
    {
        $response = new Response();
        $response->setMsg(sprintf('hello, %s', $request->getName()));
        return $response;
    }

}
