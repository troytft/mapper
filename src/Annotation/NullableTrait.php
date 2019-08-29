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
    public function getNullable(): ?bool
    {
        return $this->nullable;
    }
}
