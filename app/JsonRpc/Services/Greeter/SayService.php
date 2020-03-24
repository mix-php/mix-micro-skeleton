<?php

namespace App\JsonRpc\Services\Greeter;

/**
 * Class SayService
 * @package App\JsonRpc\Services\Greeter
 */
class SayService
{

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
