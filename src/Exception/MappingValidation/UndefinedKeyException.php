<?php

namespace Mapper\Exception\MappingValidation;

class UndefinedKeyException extends AbstractMappingValidationException
{
    public function __construct(array $path)
    {
        parent::__construct('Undefined key', $path);
    }
}
