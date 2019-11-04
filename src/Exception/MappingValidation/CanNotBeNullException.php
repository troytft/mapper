<?php

namespace Mapper\Exception\MappingValidation;

use Mapper\Exception\PathTrait;

class CanNotBeNullException extends \Exception implements MappingValidationExceptionInterface
{
    use PathTrait;

    /**
     * @param array $path
     */
    public function __construct(array $path)
    {
        $this->path = $path;

        parent::__construct();
    }
}
