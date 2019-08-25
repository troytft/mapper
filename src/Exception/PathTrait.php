<?php

namespace Mapper\Exception;

use function join;

trait PathTrait
{
    /**
     * @var array
     */
    protected $path;

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
    public function getPathAsString()
    {
        return join('.', $this->path);
    }
}
