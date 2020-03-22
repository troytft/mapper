<?php

namespace Mapper\DTO\Schema;

interface ObjectTypeInterface extends TypeInterface
{
    /**
     * @return string
     */
    public function getClassName(): string;

    /**
     * @return TypeInterface[]
     */
    public function getProperties(): array;
}
