<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Php\Micro\Srv\Curl;

/**
 */
class GetClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Php\Micro\Srv\Curl\Request $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Hello(\Php\Micro\Srv\Curl\Request $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/php.micro.srv.curl.Get/Hello',
        $argument,
        ['\Php\Micro\Srv\Curl\Response', 'decode'],
        $metadata, $options);
    }

}
