<?php

namespace Mapper\Exception\MappingValidation;

use Mapper\Exception\PathTrait;

class UndefinedKeyException extends \Exception implements MappingValidationExceptionInterface
{
    use PathTrait;

    public function __construct(array $path)
    {
        $this->path = $path;

        parent::__construct();
    }
}
