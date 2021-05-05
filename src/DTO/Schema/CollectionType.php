<?php

namespace Mapper\DTO\Schema;

class CollectionType implements CollectionTypeInterface
{
    private TypeInterface $items;
    private bool $nullable;
    private ?string $transformerName;
    private array $transformerOptions = [];
    private ?string $setterName = null;

    /**
     * @return TypeInterface
     */
    public function getItems(): TypeInterface
    {
        return $this->items;
    }

    /**
     * @param TypeInterface $items
     *
     * @return $this
     */
    public function setItems(TypeInterface $items)
    {
        $this->items = $items;

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
