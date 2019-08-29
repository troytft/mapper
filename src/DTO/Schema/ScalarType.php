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
    private $transformer;

    /**
     * @return bool
     */
    public function getNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @param bool $nullable
     *
     * @return $this
     */
    public function setNullable(bool $nullable)
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransformer(): ?string
    {
        return $this->transformer;
    }

    /**
     * @param string|null $transformer
     *
     * @return $this
     */
    public function setTransformer(?string $transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }
}
