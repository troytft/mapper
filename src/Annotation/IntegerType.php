<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;
use Mapper\Transformer\IntegerTransformer;

/**
 * @Annotation
 */
class IntegerType implements ScalarTypeInterface
{
    use NullableTrait;

    public function getTransformerName(): string
    {
        return IntegerTransformer::getName();
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
