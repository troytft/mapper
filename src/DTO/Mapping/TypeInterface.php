<?php

namespace Mapper\DTO\Mapping;

interface TypeInterface
{
    /**
     * @return bool|null
     */
    public function getNullable(): ?bool;
}
