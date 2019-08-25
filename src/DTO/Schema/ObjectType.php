<?php

namespace Mapper\DTO\Schema;

class ObjectType implements ObjectTypeInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var TypeInterface[]
     */
    private $properties;

    /**
     * @var bool
     */
    private $isNullable;

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function setClass(string $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return TypeInterface[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param TypeInterface[] $properties
     *
     * @return $this
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsNullable(): bool
    {
        return $this->isNullable;
    }

    /**
     * @param bool $isNullable
     *
     * @return $this
     */
    public function setIsNullable(bool $isNullable)
    {
        $this->isNullable = $isNullable;

        return $this;
    }
}
