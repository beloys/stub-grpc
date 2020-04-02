<?php

use Beloys\StubGrpc\StubGrpc;
use Grpc\BaseStub;
use Grpc\Health\V1\HealthCheckRequest;
use Grpc\Health\V1\HealthCheckResponse;
use Grpc\Health\V1\HealthClient;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testMakeWithoutOptions()
    {
        $stub = StubGrpc::make(BaseStub::class);
        $this->assertInstanceOf(BaseStub::class, $stub);
    }

    public function testMakeWithMessage()
    {
        $stub = StubGrpc::make(HealthClient::class, [
            '/grpc.health.v1.Health/Check' => new HealthCheckResponse(['status' => HealthCheckResponse\ServingStatus::SERVING]),
        ]);
        /** @var HealthCheckResponse $res */
        [$res, $meta] = $stub->Check(new HealthCheckRequest())->wait();
        $this->assertInstanceOf(HealthCheckResponse::class, $res);
        $this->assertEquals(HealthCheckResponse\ServingStatus::SERVING, $res->getStatus());
        $this->assertNotNull($meta);
    }

    public function testMakeWithMessageAndMeta()
    {
        $stub = StubGrpc::make(HealthClient::class, [
            '/grpc.health.v1.Health/Check' => [
                new HealthCheckResponse(['status' => HealthCheckResponse\ServingStatus::SERVING]),
                (object) ['message' => 'hello'],
            ],
        ]);
        /** @var HealthCheckResponse $res */
        [$res, $meta] = $stub->Check(new HealthCheckRequest())->wait();
        $this->assertInstanceOf(HealthCheckResponse::class, $res);
        $this->assertEquals(HealthCheckResponse\ServingStatus::SERVING, $res->getStatus());
        $this->assertEquals('hello', $meta->message);
    }

    public function testMakeMetaWithoutMessage()
    {
        $stub = StubGrpc::make(HealthClient::class, [
            '/grpc.health.v1.Health/Check' => [
               null,
                (object) ['message' => 'hello'],
            ],
        ]);
        /** @var null $res */
        [$res, $meta] = $stub->Check(new HealthCheckRequest())->wait();
        $this->assertNull($res);
        $this->assertEquals('hello', $meta->message);
    }

    public function testMakeWithCallable()
    {
        $stub = StubGrpc::make(HealthClient::class, [
            '/grpc.health.v1.Health/Check' => function (HealthCheckRequest $request) {
                $this->assertEquals('123', $request->getService());

                return [new HealthCheckResponse(['status' => HealthCheckResponse\ServingStatus::SERVING]), null];
            },
        ]);
        /** @var HealthCheckResponse $res */
        [$res, $meta] = $stub->Check(new HealthCheckRequest(['service' => '123']))->wait();
        $this->assertInstanceOf(HealthCheckResponse::class, $res);
        $this->assertEquals(HealthCheckResponse\ServingStatus::SERVING, $res->getStatus());
        $this->assertNull($meta);
    }

    public function testMakeWithCallableThatReturnError()
    {
        $stub = StubGrpc::make(HealthClient::class, [
            '/grpc.health.v1.Health/Check' => function () {
                return [null,  (object) ['message' => 'hello']];
            },
        ]);
        /** @var null $res */
        [$res, $meta] = $stub->Check(new HealthCheckRequest(['service' => '123']))->wait();
        $this->assertNull($res);
        $this->assertEquals('hello', $meta->message);
    }
}
