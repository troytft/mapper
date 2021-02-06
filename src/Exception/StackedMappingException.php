<?php

namespace Mapper\Exception;

use Mapper;

class StackedMappingException extends \Exception
{
    /**
     * @var Mapper\Exception\StackableMappingExceptionInterface[]
     */
    private $exceptions;

    /**
     * @param Mapper\Exception\StackableMappingExceptionInterface[] $exceptions
     */
    public function __construct(array $exceptions)
    {
        parent::__construct();

        $this->exceptions = $exceptions;
    }

    /**
     * @return Mapper\Exception\StackableMappingExceptionInterface[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
