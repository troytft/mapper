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
    private $isAllowedUndefinedKeysInData;

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
    public function getIsAllowedUndefinedKeysInData(): bool
    {
        return $this->isAllowedUndefinedKeysInData;
    }

    /**
     * @param bool $isAllowedUndefinedKeysInData
     *
     * @return $this
     */
    public function setIsAllowedUndefinedKeysInData(bool $isAllowedUndefinedKeysInData)
    {
        $this->isAllowedUndefinedKeysInData = $isAllowedUndefinedKeysInData;

        return $this;
    }
}
