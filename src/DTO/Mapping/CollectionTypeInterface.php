<?php

namespace Mapper\DTO\Mapping;

interface CollectionTypeInterface extends TypeInterface
{
    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface;
}
