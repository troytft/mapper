<?php

namespace Mapper\DTO\Mapping;

interface ObjectTypeInterface extends TypeInterface
{
    /**
     * @return string
     */
    public function getClassName(): string;
}
