<?php

namespace Madewithlove\Broadway\MongoDB\ReadModel;

use MongoDB\Client;

class MongoDBClientFactory
{
    /**
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * @var string
     */
    protected $port = '27017';

    /**
     * @var array
     */
    protected $typeMap = [
        'array' => 'array',
        'document' => 'array',
        'root' => 'array',
    ];

    /**
     * @param array $config
     *
     * @return Client
     */
    public function create(array $config = [])
    {
        $host = isset($config['host']) ? $config['host'] : $this->host;
        $port = isset($config['port']) ? $config['port'] : $this->port;
        $driverOptions = isset($config['driver']) ? $config['driver'] : [
            'typeMap' => $this->typeMap,
        ];

        return new Client(
            $this->getDsn($host, $port),
            [],
            $driverOptions
        );
    }

    /**
     * @param $host
     * @param $port
     *
     * @return string
     */
    protected function getDsn($host, $port)
    {
        return sprintf('mongodb://%s:%s', $host, $port);
    }
}
