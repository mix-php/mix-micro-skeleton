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
     * @param \Php\Micro\Grpc\User\Request $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Add(\Php\Micro\Grpc\User\Request $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/php.micro.grpc.user.User/Add',
        $argument,
        ['\Php\Micro\Grpc\User\Response', 'decode'],
        $metadata, $options);
    }

}
