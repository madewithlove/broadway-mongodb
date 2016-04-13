<?php

namespace Madewithlove\Broadway\MongoDB\Dummies;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;

class Object implements SerializableInterface, ReadModelInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $foo;

    /**
     * @param string $id
     * @param string $foo
     */
    public function __construct($id, $foo)
    {
        $this->id = $id;
        $this->foo = $foo;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new self($data['id'], $data['foo']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id' => $this->id,
            'foo' => $this->foo,
        ];
    }

}
