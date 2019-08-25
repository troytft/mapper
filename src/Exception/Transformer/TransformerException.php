<?php

namespace Mapper\Exception\Transformer;

class TransformerException extends \Exception implements TransformerExceptionInterface
{
    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
