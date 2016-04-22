<?php

namespace Madewithlove\Broadway\MongoDB\ReadModel;

use Broadway\Serializer\SimpleInterfaceSerializer;
use Madewithlove\Broadway\MongoDB\Dummies\Object;
use Madewithlove\Broadway\MongoDB\TestCase;
use Madewithlove\Broadway\MongoDB\MongoDBClientFactory;

class MongoDBRepositoryTest extends TestCase
{
    /**
     * @return \Broadway\ReadModel\RepositoryInterface
     */
    private function getRepository()
    {
        $database = 'testing';

        $serializer = new SimpleInterfaceSerializer();
        $client = (new MongoDBClientFactory())->create([
            'database' => $database,
        ]);

        $client->dropDatabase($database);

        $factory = new Factory($serializer, $client->selectDatabase($database));

        return $factory->create('dummies');
    }

    /**
     * @param MongoDBRepository $repository
     * @param int $amount
     */
    private function createObjects(MongoDBRepository $repository, $amount = 1)
    {
        for ($i = 0; $i < $amount; $i++) {
            $item = new Object($i + 1, $i);
            $repository->save($item);
        }
    }

    public function testCanFindAnDeserialize()
    {
        $repository = $this->getRepository();

        $entity = new Object(1, 'foo');
        $repository->save($entity);

        $result = $repository->find(1);

        $this->assertInstanceOf(Object::class, $result);
        $this->assertEquals($entity->serialize(), $result->serialize());
    }

    public function testCanFindAll()
    {
        $repository = $this->getRepository();

        $this->createObjects($repository, 5);

        $result = $repository->findAll();
        $this->assertCount(5, $result);
    }

    public function testCanFindAllByQuery()
    {
        $repository = $this->getRepository();

        $this->createObjects($repository, 5);

        $result = $repository->findBy(['id' => 1]);
        $this->assertCount(1, $result);
    }

    public function testCanRemove()
    {
        $repository = $this->getRepository();

        $entity = new Object(1, 'foo');
        $repository->save($entity);
        $repository->remove(1);

        $result = $repository->find(1);
        $this->assertNull($result);
    }

    public function testCanUpdateExistingEntities()
    {
        $repository = $this->getRepository();

        $entity = new Object(1, 'foo');
        $repository->save($entity);
        $repository->save($entity);

        $result = $repository->findBy(['id' => 1]);
        $this->assertCount(1, $result);
    }
}
