<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;
use Mapper\Transformer\FloatTransformer;

/**
 * @Annotation
 */
class FloatType implements ScalarTypeInterface
{
    use NullableTrait;

    public function getTransformerName(): string
    {
        return FloatTransformer::getName();
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
