<?php

namespace Mapper\DTO\Schema;

class ScalarType implements ScalarTypeInterface
{
    private bool $nullable;
    private ?string $transformerName;
    private array $transformerOptions = [];
    private ?string $setterName = null;

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

    public function getSetterName(): ?string
    {
        return $this->setterName;
    }

    public function setSetterName(?string $setterName)
    {
        $this->setterName = $setterName;

        return $this;
    }
}
