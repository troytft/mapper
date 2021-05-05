<?php

namespace Mapper\DTO\Schema;

interface TypeInterface
{
    public function getNullable(): bool;
    public function getTransformerName(): ?string;
    public function getTransformerOptions(): array;
    public function getSetterName(): ?string;
    public function setSetterName(string $value);
}
