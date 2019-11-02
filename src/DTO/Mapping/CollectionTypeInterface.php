<?php

namespace Mapper\DTO\Mapping;

interface CollectionTypeInterface extends TypeInterface
{
    public function getType(): TypeInterface;
}
