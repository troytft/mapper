<?php

namespace Mapper\DTO\Schema;

interface TypeInterface
{
    /**
     * @return bool
     */
    public function getNullable(): bool;
}
