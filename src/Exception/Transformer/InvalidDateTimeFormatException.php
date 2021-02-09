<?php

namespace Mapper\Exception\Transformer;

class InvalidDateTimeFormatException extends \Exception implements TransformerExceptionInterface
{
    /**
     * @var string
     */
    private $format;

    /**
     * @param string $errorMessage
     */
    public function __construct(string $errorMessage)
    {
        parent::__construct();

        $this->format = $errorMessage;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }
}
