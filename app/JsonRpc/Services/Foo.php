<?php

namespace App\JsonRpc\Services;

/**
 * Class Foo
 * @package App\JsonRpc\Services
 * @author liu,jian <coder.keda@gmail.com>
 */
class Foo
{

    /**
     * Bar
     * @param int $a
     * @param int $b
     * @return int
     */
    public function Bar(int $a, int $b): int
    {
        return $a + $b;
    }

}
