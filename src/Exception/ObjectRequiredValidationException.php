<?php

namespace Mapper\Exception;

class ObjectRequiredValidationException extends AbstractMappingValidationException
{
    public function __construct(array $path)
    {
        parent::__construct('Value should be object', $path);
    }
}
