<?php

namespace Madewithlove\Broadway\MongoDB\ReadModel;

use Broadway\ReadModel\RepositoryFactoryInterface;
use Broadway\Serializer\SerializerInterface;
use MongoDB\Database;

class Factory implements RepositoryFactoryInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var Database
     */
    protected $connection;

    /**
     * @param SerializerInterface $serializer
     * @param Database $connection
     */
    public function __construct(SerializerInterface $serializer, Database $connection)
    {
        $this->serializer = $serializer;
        $this->connection = $connection;
    }

    /**
     * @param string $name
     * @param string $class
     *
     * @return mixed
     */
    public function create($name, $class = MongoDBRepository::class)
    {
        return new $class(
            $this->serializer,
            $this->connection,
            $name
        );
    }
}
