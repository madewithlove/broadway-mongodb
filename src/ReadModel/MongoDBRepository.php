<?php

namespace Madewithlove\Broadway\MongoDB\ReadModel;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\ReadModel\RepositoryInterface;
use Broadway\Serializer\SerializerInterface;
use MongoDB\Database;
use MongoDB\Driver\Cursor;

class MongoDBRepository implements RepositoryInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var Database
     */
    protected $database;

    /**
     * @var string
     */
    protected $collection;

    /**
     * @param SerializerInterface $serializer
     * @param Database $database
     * @param string $collection
     */
    public function __construct(SerializerInterface $serializer, Database $database, $collection)
    {
        $this->serializer = $serializer;
        $this->database = $database;
        $this->collection = $collection;
    }

    /**
     * @param ReadModelInterface $data
     *
     * @return mixed
     */
    public function save(ReadModelInterface $data)
    {
        $id = $data->getId();

        $payload = $this->serializer->serialize($data);
        $payload['id'] = $id;

        $item = $this->find($id);

        if ($item) {
            $this->newQuery()->replaceOne(['id' => $id], $payload);
        } else {
            $this->newQuery()->insertOne($payload);
        }
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->newQuery()->findOne([
            'id' => $id,
        ]);

        if (!$result) {
            return null;
        }

        return $this->deserialize($result);
    }

    /**
     * @param array $fields
     *
     * @return mixed
     */
    public function findBy(array $fields)
    {
        return $this->deserializeAll($this->newQuery()->find($fields));
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->findBy([]);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function remove($id)
    {
        $this->newQuery()->deleteOne([
            'id' => $id,
        ]);
    }

    /**
     * @param $result
     *
     * @return array
     */
    private function deserialize($result)
    {
        return $this->serializer->deserialize($result);
    }

    /**
     * @param Cursor $cursor
     *
     * @return array
     */
    private function deserializeAll(Cursor $cursor)
    {
        $items = [];

        foreach ($cursor as $result) {
            $items[] = $this->deserialize($result);
        }

        return $items;
    }

    /**
     * @return \MongoDB\Collection
     */
    private function newQuery()
    {
        return $this->database->selectCollection($this->collection);
    }
}
