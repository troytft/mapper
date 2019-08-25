<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;

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
