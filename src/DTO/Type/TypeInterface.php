<?php

namespace Mapper\DTO\Type;

interface TypeInterface
{
    /**
     * @return bool|null
     */
    public function getIsNullable(): ?bool;
}
