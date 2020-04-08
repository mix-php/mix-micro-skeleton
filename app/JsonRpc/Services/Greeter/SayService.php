<?php

namespace App\JsonRpc\Services\Greeter;

use Mix\JsonRpc\Message\Context;
use Mix\JsonRpc\Message\Request;

/**
 * Class SayService
 * @package App\JsonRpc\Services\Greeter
 */
class SayService
{

    /**
     * CurlService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
    }

    /**
     * Hello
     * @param Context $context
     * @param string $name
     * @return string
     */
    public function Hello(Context $context, string $name): string
    {
        return sprintf('hello, %s', $name);
    }

}
