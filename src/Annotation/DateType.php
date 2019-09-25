<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;
use Mapper\Transformer\DateTransformer;

/**
 * @Annotation
 */
class DateType implements ScalarTypeInterface
{
    use NullableTrait;

    public function getTransformer(): string
    {
        return DateTransformer::class;
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
