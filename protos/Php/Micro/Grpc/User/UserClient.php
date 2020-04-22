<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Php\Micro\Grpc\User;

/**
 */
class UserClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Php\Micro\Grpc\User\AddRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Php\Micro\Grpc\User\AddResponse
     */
    public function Add(\Php\Micro\Grpc\User\AddRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/php.micro.grpc.user.User/Add',
        $argument,
        ['\Php\Micro\Grpc\User\AddResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Php\Micro\Grpc\User\GetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Php\Micro\Grpc\User\GetResponse
     */
    public function Get(\Php\Micro\Grpc\User\GetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/php.micro.grpc.user.User/Get',
        $argument,
        ['\Php\Micro\Grpc\User\GetResponse', 'decode'],
        $metadata, $options);
    }

}
