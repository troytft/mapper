<?php

namespace Mapper\Exception;

class ScalarRequiredValidationException extends AbstractMappingValidationException
{
    public function __construct(array $path)
    {
        parent::__construct('Value should be scalar', $path);
    }
}
