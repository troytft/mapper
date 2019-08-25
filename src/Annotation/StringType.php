<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;

/**
 * @Annotation
 */
class StringType implements ScalarTypeInterface
{
    use NullableTrait;
}
