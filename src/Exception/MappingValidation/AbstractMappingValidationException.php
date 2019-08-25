<?php

namespace Mapper\Exception\MappingValidation;

use function join;
use Mapper\Exception\ExceptionInterface;

abstract class AbstractMappingValidationException extends \Exception implements ExceptionInterface
{
    /**
     * @var array
     */
    private $path;

    /**
     * @param string $message
     * @param array $path
     */
    public function __construct(string $message, array $path)
    {
        $this->path = $path;

        parent::__construct($message);
    }

    /**
     * @return array
     */
    public function getPath(): array
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getPathAsString(): string
    {
        return join('.', $this->path);
    }
}
