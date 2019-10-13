<?php

namespace Mapper\Exception\MappingValidation;

use Mapper\Exception\ExceptionInterface;

interface MappingValidationExceptionInterface extends ExceptionInterface
{
    public function getPath(): array;
    public function getPathAsString(): string;
}
