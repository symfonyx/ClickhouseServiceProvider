<?php

namespace Symfonyx\Silex;

use InvalidArgumentException;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use ClickHouseDB\Client;

/**
 * Silex Clickhouse component Provider.
 * @package Symfonyx\Silex
 */
class ClickhouseServiceProvider implements ServiceProviderInterface
{
    /** @var string */
    protected $prefix;

    /**
     * @param string $prefix Prefix name used to register the service provider in Silex.
     */
    public function __construct($prefix = 'clickhouse')
    {
        if (empty($prefix)) {
            throw new InvalidArgumentException('The specified prefix is not valid.');
        }

        $this->prefix = $prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $prefix = $this->prefix;

        $app["$prefix.default_params"] = [
            'host' => '127.0.0.1',
            'port' => '8123',
            'username' => 'default',
            'password' => '',
            'dbname' => 'default',
            'timeout' => 10,
            'connect_timeout' => 5
        ];

        $app["$prefix.params"] = !empty($app["$prefix.params"])
            ? array_merge($app["$prefix.default_params"], $app["$prefix.params"])
            : $app["$prefix.default_params"];

        $app["$prefix"] = function ($app) use ($prefix) {
            $param = $app["$prefix.params"];

            $db = new Client([
                'host' => $param['host'],
                'port' => $param['port'],
                'username' => $param['username'],
                'password' => $param['password'],
            ]);
            $db->database($param['dbname']);
            $db->setTimeout($param['timeout']);
            $db->setConnectTimeOut($param['connect_timeout']);

            return $db;
        };
    }
}
