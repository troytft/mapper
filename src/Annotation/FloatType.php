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

    public function getTransformer(): string
    {
        return FloatTransformer::class;
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
