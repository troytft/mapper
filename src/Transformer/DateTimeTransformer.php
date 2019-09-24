<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\DateTimeWithFormatRequiredException;

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
     * @throws DateTimeWithFormatRequiredException
     */
    public function transform($value, array $options)
    {
        $result = \DateTime::createFromFormat($this->format, $value);
        if ($result === false) {
            throw new DateTimeWithFormatRequiredException($this->format);
        }

        if ($this->isForceToLocalTimezone) {
            $dateTime = new \DateTime();
            $result->setTimezone($dateTime->getTimezone());
        }

        return $result;
    }
}
