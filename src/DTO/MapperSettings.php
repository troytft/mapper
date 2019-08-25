<?php

namespace Mapper\DTO;

class MapperSettings
{
    /**
     * @var bool
     */
    private $isPropertiesNullableByDefault;

    /**
     * @var bool
     */
    private $isUndefinedKeysInDataAllowed;

    /**
     * @return bool
     */
    public function getIsPropertiesNullableByDefault(): bool
    {
        return $this->isPropertiesNullableByDefault;
    }

    /**
     * @param bool $isPropertiesNullableByDefault
     *
     * @return $this
     */
    public function setIsPropertiesNullableByDefault(bool $isPropertiesNullableByDefault)
    {
        $this->isPropertiesNullableByDefault = $isPropertiesNullableByDefault;

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
