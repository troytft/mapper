<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;
use Mapper\Transformer\DateTimeTransformer;

/**
 * @Annotation
 */
class DateTimeType implements ScalarTypeInterface
{
    use NullableTrait;

    public function getTransformer(): string
    {
        return DateTimeTransformer::class;
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
