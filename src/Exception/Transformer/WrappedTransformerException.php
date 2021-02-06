<?php

namespace Mapper\Exception\Transformer;

use Mapper\Exception\PathAwareExceptionInterface;
use Mapper\Exception\PathTrait;

class WrappedTransformerException extends \Exception implements PathAwareExceptionInterface
{
    use PathTrait;

    public function __construct(TransformerExceptionInterface $transformerException, array $path)
    {
        $this->path = $path;

        parent::__construct($transformerException->getMessage(), 0, $transformerException);
    }
}
