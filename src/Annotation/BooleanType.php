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

    /**
     * @var string
     */
    public $transformer = BooleanTransformer::class;

    /**
     * @return string
     */
    public function getTransformer(): string
    {
        return $this->transformer;
    }
}
