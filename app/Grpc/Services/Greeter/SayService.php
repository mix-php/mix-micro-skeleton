<?php

namespace App\Grpc\Services\Greeter;

use Mix\Context\Context;
use Php\Micro\Srv\Greeter\Response;
use Php\Micro\Srv\Greeter\SayInterface;

/**
 * Class SayService
 * @package App\Grpc\Services\Greeter
 */
class SayService implements SayInterface
{

    public function Hello(Context $ctx, \Php\Micro\Srv\Greeter\Request $req): Response
    {
        $response = new Response();
        $response->setMsg(sprintf('hello, %s', $req->getName()));
        return $response;
    }

}
