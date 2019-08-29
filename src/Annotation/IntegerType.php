<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;
use Mapper\Transformer\IntegerTransformer;

/**
 * @Annotation
 */
class IntegerType implements ScalarTypeInterface
{
    use NullableTrait;

    /**
     * @var string
     */
    public $transformer = IntegerTransformer::class;

    /**
     * @return string
     */
    public function getTransformer(): string
    {
        return $this->transformer;
    }
}
