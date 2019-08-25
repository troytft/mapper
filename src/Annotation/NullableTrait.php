<?php

namespace Mapper\Annotation;

trait NullableTrait
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
