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

    public function getTransformer(): string
    {
        return TimestampTransformer::class;
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
