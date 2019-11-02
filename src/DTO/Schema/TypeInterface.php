<?php

namespace Mapper\DTO\Schema;

interface TypeInterface
{
    /**
     * @return bool
     */
    public function getNullable(): bool;

    public function getTransformer(): ?string;
    public function getTransformerOptions(): array;
}
