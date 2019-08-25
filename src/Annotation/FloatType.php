<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;

/**
 * @Annotation
 */
class FloatType implements ScalarTypeInterface
{
    use NullableTrait;
}
