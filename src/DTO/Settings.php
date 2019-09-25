<?php

namespace Mapper\DTO;

class Settings
{
    /**
     * @var bool
     */
    private $isPropertiesNullableByDefault = false;

    /**
     * @var bool
     */
    private $isAllowedUndefinedKeysInData = false;

    public function getIsPropertiesNullableByDefault(): bool
    {
        return $this->isPropertiesNullableByDefault;
    }

    public function setIsPropertiesNullableByDefault(bool $isPropertiesNullableByDefault)
    {
        $this->isPropertiesNullableByDefault = $isPropertiesNullableByDefault;

        return $this;
    }

    public function getIsAllowedUndefinedKeysInData(): bool
    {
        return $this->isAllowedUndefinedKeysInData;
    }

    public function setIsAllowedUndefinedKeysInData(bool $isAllowedUndefinedKeysInData)
    {
        $this->isAllowedUndefinedKeysInData = $isAllowedUndefinedKeysInData;

        return $this;
    }
}
