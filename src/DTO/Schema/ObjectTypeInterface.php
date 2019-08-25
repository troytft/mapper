<?php

namespace Mapper\DTO\Schema;

interface ObjectTypeInterface extends TypeInterface
{
    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @return TypeInterface[]
     */
    public function getProperties(): array;
}
