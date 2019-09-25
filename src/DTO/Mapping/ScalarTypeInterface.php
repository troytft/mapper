<?php

namespace Mapper\DTO\Mapping;

interface ScalarTypeInterface extends TypeInterface
{
    public function getTransformer(): string;
    public function getTransformerOptions(): array;
}
