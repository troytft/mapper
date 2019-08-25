<?php

namespace Mapper\DTO\Schema;

interface CollectionTypeInterface extends TypeInterface
{
    /**
     * @return TypeInterface
     */
    public function getItems(): TypeInterface;
}
