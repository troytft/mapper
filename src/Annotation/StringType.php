<?php

namespace Mapper\Annotation;

use Mapper\Transformer\StringTransformer;

/**
 * @Annotation
 */
class StringType implements ScalarTypeInterface
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
     * @return string
     */
    public function getTransformer(): string
    {
        return StringTransformer::class;
    }

    /**
     * @return array
     */
    public function getTransformerOptions(): array
    {
        return [];
    }
}
