<?php

namespace Madewithlove\Broadway\MongoDB;

use MongoDB\Client;

class MongoDBClientFactory
{
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
        $options = [];
        $driverOptions = isset($config['driver']) ? $config['driver'] : [
            'typeMap' => $this->typeMap,
        ];

        if (isset($config['username'])) {
            $options['username'] = $config['username'];
        }

        if (isset($config['password'])) {
            $options['password'] = $config['password'];
        }

        return new Client(
            $this->getDsn($config),
            $options,
            $driverOptions
        );
    }

    /**
     * @param $config
     *
     * @see https://github.com/jenssegers/laravel-mongodb/blob/master/src/Jenssegers/Mongodb/Connection.php#L164
     * @return string
     */
    protected function getDsn(array $config)
    {
        if (isset($config['dsn'])) {
            return $config['dsn'];
        }

        if (!isset($config['database'])) {
            throw new \InvalidArgumentException('database not set on $config');
        } else {
            $database = $config['database'];
        }

        $host = isset($config['host']) ? $config['host'] : '127.0.0.1';

        $hosts = is_array($host) ? $host : [$host];

        foreach ($hosts as &$host) {
            if (strpos($host, ':') === false and isset($config['port'])) {
                $port = $config['port'];
                $host = "$host:$port";
            }
        }

        return "mongodb://".implode(',', $hosts)."/{$database}";
    }
}
