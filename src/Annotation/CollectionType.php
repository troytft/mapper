<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\CollectionTypeInterface;
use Mapper\DTO\Mapping\TypeInterface;

/**
 * @Annotation
 */
class CollectionType implements CollectionTypeInterface
{
    use NullableTrait;

    /**
     * Type hint forced to object, cause annotation reader doesn't support interfaces
     *
     * @var object
     */
    public $type;

    public function getType(): TypeInterface
    {
        if (!$this->type instanceof TypeInterface) {
            throw new \InvalidArgumentException();
        }

        return $this->type;
    }

    public function getTransformer(): ?string
    {
        return null;
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
