<?php

namespace Mapper\Exception\Transformer;

class InvalidDateTimeException extends \Exception implements TransformerExceptionInterface
{
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @param string $errorMessage
     */
    public function __construct(string $errorMessage)
    {
        parent::__construct();

        $this->errorMessage = $errorMessage;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
