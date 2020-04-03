<?php

namespace App\JsonRpc\Services\Greeter;

use Mix\JsonRpc\Message\Request;

/**
 * Class SayService
 * @package App\JsonRpc\Services\Greeter
 */
class SayService
{

    /**
     * @var Request
     */
    public $request;

    /**
     * CurlService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Hello
     * @param string $name
     * @return string
     */
    public function Hello(string $name): string
    {
        return sprintf('hello, %s', $name);
    }

}
