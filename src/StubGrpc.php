<?php

namespace Beloys\StubGrpc;

use Beloys\StubGrpc\Exception\StubGrpcException;
use Beloys\StubGrpc\Invoker\MockCallInvoker;
use Google\Protobuf\Internal\Message;
use Grpc\BaseStub;
use Grpc\ChannelCredentials;
use stdClass;

class StubGrpc
{
    /** @var string */
    private $className;
    /** @var callable[] */
    private $methods = [];

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    /**
     * @throws StubGrpcException
     */
    public static function make(string $className, array $options = []): BaseStub
    {
        $mock = new self($className);

        foreach ($options as $method => $res) {
            if (is_callable($res)) {
                $mock->methodWillCall($method, $res);
                continue;
            }

            if ($res instanceof Message || null === $res) {
                $mock->methodWillReturn($method, $res);
                continue;
            }

            if (is_array($res)) {
                $mock->methodWillReturn($method, $res[0] ?? null, $res[1] ?? null);
                continue;
            }

            throw new StubGrpcException('Invalid definition, should be Message | null | array');
        }

        return $mock->build();
    }

    public function methodWillReturn(string $name, ?Message $message = null, $meta = null): self
    {
        if (null === $meta) {
            $meta = new stdClass();
        }
        $this->methods[$name] = static function () use ($message, $meta) {
            return [$message, $meta];
        };

        return $this;
    }

    public function methodWillCall(string $name, callable $func): self
    {
        $this->methods[$name] = $func;

        return $this;
    }

    /**
     * @return BaseStub|mixed
     */
    public function build(): BaseStub
    {
        $class = $this->className;

        return new $class('', [
            'credentials' => ChannelCredentials::createInsecure(),
            'grpc_call_invoker' => new MockCallInvoker($this->methods),
        ]);
    }
}
