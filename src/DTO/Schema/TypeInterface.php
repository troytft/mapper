<?php

namespace Mapper\DTO\Schema;

interface TypeInterface
{
    /**
     * @return bool
     */
    public function getNullable(): bool;

    public function getTransformerName(): ?string;
    public function getTransformerOptions(): array;
}
