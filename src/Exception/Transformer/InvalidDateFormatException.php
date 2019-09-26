<?php

namespace Mapper\Exception\Transformer;

class InvalidDateFormatException extends \Exception implements TransformerExceptionInterface
{
    /**
     * @var string
     */
    private $format;

    /**
     * @param string $format
     */
    public function __construct(string $format)
    {
        parent::__construct();

        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }
}
