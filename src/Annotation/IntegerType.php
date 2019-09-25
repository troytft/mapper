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

    public function getTransformer(): string
    {
        return IntegerTransformer::class;
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
