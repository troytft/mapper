<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\InvalidDateFormatException;

class DateTransformer implements TransformerInterface
{
    /**
     * @var string
     */
    private $format = 'Y-m-d';

    /**
     * @param $value
     * @param array $options
     *
     * @return \DateTime
     * @throws InvalidDateFormatException
     */
    public function transform($value, array $options)
    {
        $result = \DateTime::createFromFormat($this->format, $value);
        if ($result === false) {
            throw new InvalidDateFormatException($this->format);
        }

        $result->setTime(0, 0);

        return $result;
    }
}
