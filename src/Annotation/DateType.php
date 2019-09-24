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

    /**
     * @var string
     */
    public $transformer = DateTransformer::class;

    /**
     * @return string
     */
    public function getTransformer(): string
    {
        return $this->transformer;
    }
}
