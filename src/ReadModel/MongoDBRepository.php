<?php

namespace Madewithlove\Broadway\MongoDB\ReadModel;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\ReadModel\RepositoryInterface;

class MongoDBRepository implements RepositoryInterface
{
    public function save(ReadModelInterface $data)
    {
        // TODO: Implement save() method.
    }

    /**
     * @param string $id
     *
     * @return ReadModelInterface|null
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * @param array $fields
     *
     * @return ReadModelInterface[]
     */
    public function findBy(array $fields)
    {
        // TODO: Implement findBy() method.
    }

    /**
     * @return ReadModelInterface[]
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @param string $id
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

}
