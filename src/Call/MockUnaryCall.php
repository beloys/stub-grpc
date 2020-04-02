<?php

namespace Beloys\StubGrpc\Call;

use Google\Protobuf\Internal\Message;
use Grpc\Channel;
use Grpc\UnaryCall;

class MockUnaryCall extends UnaryCall
{
    /** @var array<string,array<callable|Message|null,object|null>> */
    private $responses = [];
    /** @var Message|null */
    private $lastData;
    /** @var array */
    private $lastMetadata = [];
    /** @var array */
    private $lastOptions = [];
    /** @var string */
    private $method = '';

    public function __construct(array $responses, Channel $channel, $method, $deserialize, array $options = [])
    {
        $this->responses = $responses;
        $this->method = $method;
        parent::__construct($channel, $method, $deserialize, $options);
    }

    public function start($data, array $metadata = [], array $options = [])
    {
        $this->lastData = $data;
        $this->lastMetadata = $metadata;
        $this->lastOptions = $options;

        return null;
    }

    public function wait()
    {
        if (!isset($this->responses[$this->method])) {
            return parent::wait();
        }

        return call_user_func($this->responses[$this->method], $this->lastData, $this->lastMetadata, $this->lastOptions);
    }
}
