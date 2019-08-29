<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;
use Mapper\Transformer\StringTransformer;

/**
 * @Annotation
 */
class StringType implements ScalarTypeInterface
{
    use NullableTrait;

    /**
     * @var string
     */
    public $transformer = StringTransformer::class;

    /**
     * @return string
     */
    public function getTransformer(): string
    {
        return $this->transformer;
    }
}
