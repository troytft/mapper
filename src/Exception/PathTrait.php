<?php

namespace Mapper\Exception;

use function join;

trait PathTrait
{
    /**
     * @var array
     */
    protected array $path = [];

    public function getPath(): array
    {
        return $this->path;
    }

    public function getPathAsString(): string
    {
        return join('.', $this->path);
    }
}
