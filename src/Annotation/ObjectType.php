<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ObjectTypeInterface;

use function is_string;

/**
 * @Annotation
 */
class ObjectType implements ObjectTypeInterface
{
    use NullableTrait;

    /**
     * @var string
     */
    public $class;

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

    public function getTransformerName(): ?string
    {
        return null;
    }

    public function getTransformerOptions(): array
    {
        return [];
    }
}
