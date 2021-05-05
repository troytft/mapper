<?php

namespace Mapper\DTO\Schema;

class ObjectType implements ObjectTypeInterface
{
    /**
     * @var TypeInterface[]
     */
    private array $properties = [];
    private string $className;
    private bool $nullable;
    private ?string $transformerName;
    private array $transformerOptions = [];
    private ?string $setterName = null;

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     *
     * @return $this
     */
    public function setClassName(string $className)
    {
        $this->className = $className;

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

    public function getTransformerName(): ?string
    {
        return $this->transformerName;
    }

    public function setTransformerName(?string $transformerName)
    {
        $this->transformerName = $transformerName;

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

    public function getSetterName(): ?string
    {
        return $this->setterName;
    }

    public function setSetterName(?string $setterName)
    {
        $this->setterName = $setterName;

        return $this;
    }
}
