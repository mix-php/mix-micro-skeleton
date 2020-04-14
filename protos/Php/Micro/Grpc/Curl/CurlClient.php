<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Php\Micro\Grpc\Curl;

/**
 */
class CurlClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Php\Micro\Grpc\Curl\Request $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Get(\Php\Micro\Grpc\Curl\Request $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/php.micro.grpc.curl.Curl/Get',
        $argument,
        ['\Php\Micro\Grpc\Curl\Response', 'decode'],
        $metadata, $options);
    }

}
