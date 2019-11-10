<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;
use Mapper\Transformer\TimestampTransformer;

/**
 * @Annotation
 */
class TimestampType implements ScalarTypeInterface
{
    use NullableTrait;

    public function getTransformerName(): string
    {
        return TimestampTransformer::getName();
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
