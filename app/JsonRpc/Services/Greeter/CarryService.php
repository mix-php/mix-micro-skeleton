<?php

namespace App\JsonRpc\Services\Greeter;

use Mix\Context\Context;
use Mix\JsonRpc\ServiceInterface;

/**
 * Class CarryService
 * @package App\JsonRpc\Services\Greeter
 */
class CarryService implements ServiceInterface
{

    /**
     * Service name
     * @var string
     */
    public const NAME = "php.micro.jsonrpc.greeter.Carry";

    /**
     * Luggage
     * @param Context $context
     * @param string $name
     * @return string
     */
    public function Luggage(Context $context, string $name): string
    {
        return sprintf('carry %s', $name);
    }

}
