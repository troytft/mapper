<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\InvalidDateTimeFormatException;

class DateTimeTransformer implements TransformerInterface
{
    /**
     * @var string
     */
    private $format = 'Y-m-d\TH:i:sP';

    /**
     * @var bool
     */
    private $isForceToLocalTimezone = true;

    /**
     * @param $value
     * @param array $options
     *
     * @return \DateTime
     * @throws InvalidDateTimeFormatException
     */
    public function transform($value, array $options)
    {
        $result = \DateTime::createFromFormat($this->format, $value);
        if ($result === false) {
            throw new InvalidDateTimeFormatException($this->format);
        }

        if ($this->isForceToLocalTimezone) {
            $dateTime = new \DateTime();
            $result->setTimezone($dateTime->getTimezone());
        }

        return $result;
    }
}
