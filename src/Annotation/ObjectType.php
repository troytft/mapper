<?php

namespace Mapper\Annotation;

use function is_string;

/**
 * @Annotation
 */
class ObjectType implements ObjectTypeInterface
{
    /**
     * @var bool|null
     */
    public $nullable;

    /**
     * @var string
     */
    public $class;

    /**
     * {@inheritDoc}
     */
    public function getIsNullable(): ?bool
    {
        return $this->nullable;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassName(): string
    {
        if (!is_string($this->class)) {
            throw new \InvalidArgumentException();
        }

        return $this->class;
    }
}
