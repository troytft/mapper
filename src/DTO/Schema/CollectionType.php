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
    private $isNullable;

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
