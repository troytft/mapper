<?php

namespace Mapper\DTO\Type;

interface CollectionTypeInterface extends TypeInterface
{
    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface;
}
