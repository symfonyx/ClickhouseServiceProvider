# ClickhouseServiceProvider
[phpClickHouse](https://github.com/smi2/phpClickHouse) Service Provider for [Silex](https://github.com/silexphp/Silex) PHP framework.

## Installation

```json
{
    "require": {
        "symfonyx/clickhouse-service-provider": "1.x-dev"
    }
}
```


## Usage

```php
use Silex\Application;
use Symfonyx\Silex\ClickhouseServiceProvider

$app = new Application();
$app['clickhouse.params'] = [
    'host' => '127.0.0.1', 
    'port' => '8123', 
    'username' => 'default', 
    'password' => '',
    'dbname' => 'default',
    'timeout' => 10,
    'connect_timeout' => 5
];
$app->register(new ClickhouseServiceProvider('clickhouse'));
```

## License

MIT License
