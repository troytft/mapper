<?php

namespace Mapper\Annotation;

use Mapper\DTO\Type\CollectionTypeInterface;
use Mapper\DTO\Type\TypeInterface;

/**
 * @Annotation
 */
class CollectionType implements CollectionTypeInterface
{
    /**
     * @var bool|null
     */
    public $nullable;

    /**
     * Type hint forced to object, cause annotation reader doesn't support interfaces
     *
     * @var object
     */
    public $type;

    /**
     * {@inheritDoc}
     */
    public function getIsNullable(): ?bool
    {
        return $this->nullable;
    }

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
