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

    public function getTransformer(): string
    {
        return BooleanTransformer::class;
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
