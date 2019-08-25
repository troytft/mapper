<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;

/**
 * @Annotation
 */
class BooleanType implements ScalarTypeInterface
{
    use NullableTrait;
}
