<?php

namespace Mapper\DTO\Mapping;

interface TypeInterface
{
    public function getNullable(): ?bool;
    public function getTransformer(): ?string;
    public function getTransformerOptions(): array;
}
