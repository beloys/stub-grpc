<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Grpc\Health\V1;

/**
 */
class HealthClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * If the requested service is unknown, the call will fail with status
     * NOT_FOUND.
     * @param \Grpc\Health\V1\HealthCheckRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Check(\Grpc\Health\V1\HealthCheckRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grpc.health.v1.Health/Check',
        $argument,
        ['\Grpc\Health\V1\HealthCheckResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Performs a watch for the serving status of the requested service.
     * The server will immediately send back a message indicating the current
     * serving status.  It will then subsequently send a new message whenever
     * the service's serving status changes.
     *
     * If the requested service is unknown when the call is received, the
     * server will send a message setting the serving status to
     * SERVICE_UNKNOWN but will *not* terminate the call.  If at some
     * future point, the serving status of the service becomes known, the
     * server will send a new message with the service's serving status.
     *
     * If the call terminates with status UNIMPLEMENTED, then clients
     * should assume this method is not supported and should not retry the
     * call.  If the call terminates with any other status (including OK),
     * clients should retry the call with appropriate exponential backoff.
     * @param \Grpc\Health\V1\HealthCheckRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Watch(\Grpc\Health\V1\HealthCheckRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/grpc.health.v1.Health/Watch',
        $argument,
        ['\Grpc\Health\V1\HealthCheckResponse', 'decode'],
        $metadata, $options);
    }

}
