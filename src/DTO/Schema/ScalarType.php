<?php

namespace Mapper\DTO\Schema;

class ScalarType implements ScalarTypeInterface
{
    /**
     * @var bool
     */
    private $isNullable;

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
}
