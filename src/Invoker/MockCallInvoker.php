<?php

namespace Beloys\StubGrpc\Invoker;

use Beloys\StubGrpc\Call\MockUnaryCall;
use Grpc\DefaultCallInvoker;

class MockCallInvoker extends DefaultCallInvoker
{
    private $unaryCallResponses;

    public function __construct(array $unaryCallResponses)
    {
        $this->unaryCallResponses = $unaryCallResponses;
    }

    public function UnaryCall($channel, $method, $deserialize, $options)
    {
        return new MockUnaryCall($this->unaryCallResponses, $channel, $method, $deserialize, $options);
    }
}
