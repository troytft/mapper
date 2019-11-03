<?php

namespace Mapper\Annotation;

trait NullableTrait
{
    /**
     * @var boolean
     */
    public $nullable;

    /**
     * {@inheritDoc}
     */
    public function getNullable(): ?bool
    {
        return $this->nullable;
    }
}
