<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: _health.proto

namespace Grpc\Health\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>grpc.health.v1.HealthCheckRequest</code>
 */
class HealthCheckRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string service = 1;</code>
     */
    private $service = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $service
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Health::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string service = 1;</code>
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Generated from protobuf field <code>string service = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setService($var)
    {
        GPBUtil::checkString($var, True);
        $this->service = $var;

        return $this;
    }

}

