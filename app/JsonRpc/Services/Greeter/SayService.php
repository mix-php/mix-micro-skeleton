<?php

namespace App\JsonRpc\Services\Greeter;

use Mix\Context\Context;
use Mix\JsonRpc\ServiceInterface;

/**
 * Class SayService
 * @package App\JsonRpc\Services\Greeter
 */
class SayService implements ServiceInterface
{

    /**
     * Service name
     * @var string
     */
    public const NAME = "php.micro.jsonrpc.greeter.Say";

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
