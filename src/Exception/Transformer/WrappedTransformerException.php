<?php

namespace Mapper\Exception\Transformer;

use Mapper\Exception\ExceptionInterface;
use Mapper\Exception\PathTrait;

class WrappedTransformerException extends \Exception implements ExceptionInterface
{
    use PathTrait;

    /**
     * @param TransformerExceptionInterface $transformerException
     * @param array $path
     */
    public function __construct(TransformerExceptionInterface $transformerException, array $path)
    {
        $this->path = $path;

        parent::__construct($transformerException->getMessage(), 0, $transformerException);
    }
}
