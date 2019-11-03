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

    /**
     * @var bool
     */
    private $isClearMissing = true;

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

    public function getIsClearMissing(): bool
    {
        return $this->isClearMissing;
    }

    public function setIsClearMissing(bool $isClearMissing)
    {
        $this->isClearMissing = $isClearMissing;

        return $this;
    }
}
