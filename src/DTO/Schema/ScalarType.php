<?php

namespace Mapper\DTO\Schema;

class ScalarType implements ScalarTypeInterface
{
    /**
     * @var bool
     */
    private $nullable;

    /**
     * @var string
     */
    private $transformer;

    /**
     * @var array
     */
    private $transformerOptions;

    public function getNullable(): bool
    {
        return $this->nullable;
    }

    public function setNullable(bool $nullable)
    {
        $this->nullable = $nullable;

        return $this;
    }

    public function getTransformer(): string
    {
        return $this->transformer;
    }

    public function setTransformer(string $transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    public function getTransformerOptions(): array
    {
        return $this->transformerOptions;
    }

    public function setTransformerOptions(array $transformerOptions)
    {
        $this->transformerOptions = $transformerOptions;

        return $this;
    }
}
