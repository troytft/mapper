<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;

/**
 * @Annotation
 */
class IntegerType implements ScalarTypeInterface
{
    use NullableTrait;
}
