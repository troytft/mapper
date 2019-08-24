<?php

namespace Mapper\Annotation;

interface CollectionTypeInterface extends TypeInterface
{
    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface;
}
