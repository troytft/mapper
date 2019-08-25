<?php

namespace Mapper\DTO\Type;

interface ObjectTypeInterface extends TypeInterface
{
    /**
     * @return string
     */
    public function getClassName(): string;
}
