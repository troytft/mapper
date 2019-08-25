<?php

namespace Mapper\Annotation;

use Mapper\DTO\Type\ScalarTypeInterface;

/**
 * @Annotation
 */
class StringType implements ScalarTypeInterface
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
