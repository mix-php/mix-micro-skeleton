<?php
# Generated by the protocol buffer compiler (https://github.com/mix-php/grpc). DO NOT EDIT!
# source: greeter.proto

namespace Php\Micro\Grpc\Greeter;

use Mix\Grpc;
use Mix\Context\Context;

interface CarryInterface extends Grpc\ServiceInterface
{
    // GRPC specific service name.
    public const NAME = "php.micro.grpc.greeter.Carry";

    /**
    * @param Context $context
    * @param Request $request
    * @return Response
    *
    * @throws Grpc\Exception\InvokeException
    */
    public function Luggage(Context $context, Request $request): Response;
}
