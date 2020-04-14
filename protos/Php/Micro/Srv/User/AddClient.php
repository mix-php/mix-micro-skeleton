<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Php\Micro\Srv\User;

/**
 */
class AddClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Php\Micro\Srv\User\Request $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Hello(\Php\Micro\Srv\User\Request $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/php.micro.srv.user.Add/Hello',
        $argument,
        ['\Php\Micro\Srv\User\Response', 'decode'],
        $metadata, $options);
    }

}
