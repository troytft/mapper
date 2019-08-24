<?php

namespace Mapper\Annotation;

use Mapper\Transformer\StringTransformer;

/**
 * @Annotation
 */
class ObjectType implements ObjectTypeInterface
{
    /**
     * @var bool
     */
    public $nullable;

    /**
     * {@inheritDoc}
     */
    public function getIsNullable(): ?bool
    {
        return $this->nullable;
    }

    /**
     * @var string
     */
    public $class;

    /**
     * @return string
     */
    public function getTransformer(): string
    {
        return StringTransformer::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassName(): string
    {
        return $this->class;
    }
}
