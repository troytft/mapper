<?php

namespace Mapper\DTO\Schema;

interface ScalarTypeInterface extends TypeInterface
{
    public function getTransformer(): string;
    public function getTransformerOptions(): array;
}
