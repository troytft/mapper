<?php

namespace Mapper\DTO\Schema;

class ScalarType implements ScalarTypeInterface
{
    /**
     * @var bool
     */
    private $isNullable;

    /**
     * @var string|null
     */
    private $transformer;

    /**
     * @return bool
     */
    public function getIsNullable(): bool
    {
        return $this->isNullable;
    }

    /**
     * @param bool $isNullable
     *
     * @return $this
     */
    public function setIsNullable(bool $isNullable)
    {
        $this->isNullable = $isNullable;

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
