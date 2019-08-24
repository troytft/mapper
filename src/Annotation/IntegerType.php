<?php

namespace Mapper\Annotation;

/**
 * @Annotation
 */
class IntegerType implements ScalarTypeInterface
{
    /**
     * @var bool|null
     */
    public $nullable;

    /**
     * {@inheritDoc}
     */
    public function getIsNullable(): ?bool
    {
        return $this->nullable;
    }
}
