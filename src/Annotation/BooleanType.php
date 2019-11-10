<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;
use Mapper\Transformer\BooleanTransformer;

/**
 * @Annotation
 */
class BooleanType implements ScalarTypeInterface
{
    use NullableTrait;

    public function getTransformerName(): string
    {
        return BooleanTransformer::getName();
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
