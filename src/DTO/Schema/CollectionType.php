<?php

namespace Mapper\DTO\Schema;

class CollectionType implements CollectionTypeInterface
{
    /**
     * @var TypeInterface
     */
    private $items;

    /**
     * @var bool
     */
    private $nullable;

    /**
     * @var string|null
     */
    private $transformerName;

    /**
     * @var array
     */
    private $transformerOptions;

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
}
