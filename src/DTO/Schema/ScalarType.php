<?php

namespace Mapper\DTO\Schema;

class ScalarType implements ScalarTypeInterface
{
    /**
     * @var bool
     */
    private $nullable;

    /**
     * @var string|null
     */
    private $transformerName;

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

    public function getTransformerName(): ?string
    {
        return $this->transformerName;
    }

    public function setTransformerName(?string $transformerName)
    {
        $this->transformerName = $transformerName;

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
