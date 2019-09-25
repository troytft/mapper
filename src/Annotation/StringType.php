<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;
use Mapper\Transformer\StringTransformer;

/**
 * @Annotation
 */
class StringType implements ScalarTypeInterface
{
    use NullableTrait;

    public function getTransformer(): string
    {
        return StringTransformer::class;
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
