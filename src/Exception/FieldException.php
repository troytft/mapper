<?php

namespace RequestModelBundle\Exception;

class FieldException extends \RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
