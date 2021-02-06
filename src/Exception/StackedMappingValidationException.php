<?php

namespace Mapper\Exception;

use Mapper;

class StackedMappingValidationException extends \Exception
{
    /**
     * @var Mapper\Exception\MappingValidation\MappingValidationExceptionInterface[]
     */
    private $exceptions;

    /**
     * @param $exceptions Mapper\Exception\MappingValidation\MappingValidationExceptionInterface[]
     */
    public function __construct(array $exceptions)
    {
        parent::__construct();

        $this->exceptions = $exceptions;
    }

    /**
     * @return Mapper\Exception\MappingValidation\MappingValidationExceptionInterface[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
