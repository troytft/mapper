<?php

namespace Mapper\DTO;

class MapperSettings
{
    /**
     * @var bool
     */
    private $defaultIsNullable;

    /**
     * @var bool
     */
    private $isUndefinedKeysInDataAllowed;

    /**
     * @return bool
     */
    public function getDefaultIsNullable(): bool
    {
        return $this->defaultIsNullable;
    }

    /**
     * @param bool $defaultIsNullable
     *
     * @return $this
     */
    public function setDefaultIsNullable(bool $defaultIsNullable)
    {
        $this->defaultIsNullable = $defaultIsNullable;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsUndefinedKeysInDataAllowed(): bool
    {
        return $this->isUndefinedKeysInDataAllowed;
    }

    /**
     * @param bool $isUndefinedKeysInDataAllowed
     *
     * @return $this
     */
    public function setIsUndefinedKeysInDataAllowed(bool $isUndefinedKeysInDataAllowed)
    {
        $this->isUndefinedKeysInDataAllowed = $isUndefinedKeysInDataAllowed;

        return $this;
    }
}
