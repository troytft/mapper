<?php

namespace RequestModelBundle\Annotation;

/**
 * @Annotation
 */
class CollectionType implements CollectionTypeInterface
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
     * @var object
     */
    public $type;

    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface
    {
        if (!$this->type instanceof TypeInterface) {
            throw new \InvalidArgumentException();
        }
        return $this->type;
    }
}
