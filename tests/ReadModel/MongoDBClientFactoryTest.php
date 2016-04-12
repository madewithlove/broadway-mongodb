<?php

namespace Madewithlove\Broadway\MongoDB\ReadModel;

use Madewithlove\Broadway\MongoDB\TestCase;
use MongoDB\Client;
use MongoDB\Driver\Manager;

class MongoDBClientFactoryTest extends TestCase
{
    public function testThrowsExceptionWhenDatabaseIsNotSet()
    {
        $factory = new MongoDBClientFactory();
        $this->setExpectedException(\InvalidArgumentException::class, 'database not set on $config');

        $factory->create([]);
    }

    public function testCanCreateClient()
    {
        $factory = new MongoDBClientFactory();

        $client = $factory->create([
            'database' => 'foo',
        ]);

        $debug = $client->__debugInfo();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals([
            'array' => 'array',
            'document' => 'array',
            'root' => 'array',
        ], $debug['typeMap']);
        $this->assertEquals('mongodb://127.0.0.1/foo', $debug['uri']);
    }

    public function testCanCreateClientWithCustomHostAndPort()
    {
        $factory = new MongoDBClientFactory();

        $client = $factory->create([
            'database' => 'foo',
            'host' => 'foo',
            'port' => '200',
        ]);

        $debug = $client->__debugInfo();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals('mongodb://foo:200/foo', $debug['uri']);
    }

    public function testCanCreateUsingPreDefinedDsn()
    {
        $factory = new MongoDBClientFactory();

        $client = $factory->create([
            'dsn' => 'mongodb://foo:200/foo',
        ]);

        $debug = $client->__debugInfo();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals('mongodb://foo:200/foo', $debug['uri']);
    }

    public function testCanCreateUsingCustomTypeMap()
    {
        $factory = new MongoDBClientFactory();

        $client = $factory->create([
            'dsn' => 'mongodb://foo:200/foo',
            'driver' => [
                'typeMap' => [
                    'array' => 'foo',
                    'document' => 'foo',
                    'root' => 'foo',
                ],
            ],
        ]);

        $debug = $client->__debugInfo();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals([
            'array' => 'foo',
            'document' => 'foo',
            'root' => 'foo',
        ], $debug['typeMap']);
    }

    public function testCanCreateClientWithCredentials()
    {
        $factory = new MongoDBClientFactory();

        $client = $factory->create([
            'dsn' => 'mongodb://foo:200/foo',
            'username' => 'foo',
            'password' => 'foo',
        ]);

        $this->assertInstanceOf(Client::class, $client);
    }
}
