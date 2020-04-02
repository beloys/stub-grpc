# Mock for gRPC requests
Mocks for gRPC clients with PHPStorm meta

### Installation 
```
composer require beloys/stub-grpc --dev
```

### Examples

```php
use Beloys\StubGrpc\StubGrpc;
use Grpc\Health\V1\HealthCheckResponse;
use Grpc\Health\V1\HealthCheckRequest;
use Grpc\Health\V1\HealthClient;

$mock = StubGrpc::make(HealthClient::class, [
    '/grpc.health.v1.Health/Check' => new HealthCheckResponse(['status' => HealthCheckResponse\ServingStatus::SERVING]),
]);

$mock = StubGrpc::make(HealthClient::class, [
    '/grpc.health.v1.Health/Check' => function(HealthCheckRequest $in){
        return [new HealthCheckResponse(), null];
    },
]);

$mock = (new StubGrpc(HealthClient::class))
  ->methodWillReturn('/cyberxpert.grpc.user.User/ViewByUuid', new HealthCheckResponse(), (object)['status' => 1])
  ->build();
```

### Tests 
```
composer tests
```
