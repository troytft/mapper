<?php

namespace Mapper\Exception\MappingValidation;

class ObjectRequiredException extends AbstractMappingValidationException
{
    public function __construct(array $path)
    {
        parent::__construct('Value should be object', $path);
    }
}
