<?php

namespace Mapper\Exception\MappingValidation;

class ScalarRequiredException extends AbstractMappingValidationException
{
    public function __construct(array $path)
    {
        parent::__construct('Value should be scalar', $path);
    }
}
