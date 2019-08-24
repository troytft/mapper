<?php

namespace RequestModelBundle\Exception;

use function join;

abstract class AbstractMappingException extends \Exception
{
    /**
     * @var array
     */
    private $path;

    /**
     * @param array $path
     */
    public function __construct(array $path)
    {
        $this->path = $path;

        parent::__construct();
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
