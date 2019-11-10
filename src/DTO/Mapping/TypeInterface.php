<?php

namespace Mapper\DTO\Mapping;

interface TypeInterface
{
    public function getNullable(): ?bool;
    public function getTransformerName(): ?string;
    public function getTransformerOptions(): array;
}
