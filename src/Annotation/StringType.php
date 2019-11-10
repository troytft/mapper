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

    public function getTransformerName(): string
    {
        return StringTransformer::getName();
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
