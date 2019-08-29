<?php

namespace Mapper\DTO\Mapping;

interface ScalarTypeInterface extends TypeInterface
{
    /**
     * @return string
     */
    public function getTransformer(): string;
}
