<?php

namespace Mapper\Exception;

class UndefinedTransformerException extends \RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
