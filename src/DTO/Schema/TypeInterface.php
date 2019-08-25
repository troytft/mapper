<?php

namespace Mapper\DTO\Schema;

interface TypeInterface
{
    /**
     * @return bool
     */
    public function getIsNullable(): bool;
}
