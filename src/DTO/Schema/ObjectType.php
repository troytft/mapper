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
    private $nullable;

    /**
     * @var string|null
     */
    private $transformer;

    /**
     * @var array
     */
    private $transformerOptions;

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
    public function getNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @param bool $nullable
     *
     * @return $this
     */
    public function setNullable(bool $nullable)
    {
        $this->nullable = $nullable;

        return $this;
    }

    public function getTransformer(): ?string
    {
        return $this->transformer;
    }

    public function setTransformer(?string $transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    public function getTransformerOptions(): array
    {
        return $this->transformerOptions;
    }

    public function setTransformerOptions(array $transformerOptions)
    {
        $this->transformerOptions = $transformerOptions;

        return $this;
    }
}
