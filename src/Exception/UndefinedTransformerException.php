<?php

namespace Mapper\Exception;

class UndefinedTransformerException extends \RuntimeException implements ExceptionInterface
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
