<?php

namespace Madewithlove\Broadway\MongoDB\ReadModel;

use Broadway\ReadModel\RepositoryFactoryInterface;
use Broadway\ReadModel\RepositoryInterface;
use Broadway\Serializer\SerializerInterface;
use MongoDB\Client;

class Factory implements RepositoryFactoryInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param SerializerInterface $serializer
     * @param Client $client
     */
    public function __construct(SerializerInterface $serializer, Client $client)
    {
        $this->serializer = $serializer;
        $this->client = $client;
    }

    /**
     * @param string $name
     * @param string $class
     *
     * @return RepositoryInterface
     */
    public function create($name, $class)
    {
        return new MongoDBRepository(
            $this->serializer,
            $this->client->selectDatabase($name),
            $class
        );
    }
}
