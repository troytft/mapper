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

    /**
     * @var string
     */
    public $transformer = TimestampTransformer::class;

    /**
     * @return string
     */
    public function getTransformer(): string
    {
        return $this->transformer;
    }
}
