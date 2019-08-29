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
}
