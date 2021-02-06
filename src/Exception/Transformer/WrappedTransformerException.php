<?php

namespace Mapper\Exception\Transformer;

use Mapper\Exception\ExceptionInterface;
use Mapper\Exception\MappingValidation\MappingValidationExceptionInterface;
use Mapper\Exception\PathTrait;

class WrappedTransformerException extends \Exception implements ExceptionInterface, MappingValidationExceptionInterface
{
    use PathTrait;

    public function __construct(TransformerExceptionInterface $transformerException, array $path)
    {
        $this->path = $path;

        parent::__construct($transformerException->getMessage(), 0, $transformerException);
    }
}
