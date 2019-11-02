<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\InvalidDateTimeFormatException;

class DateTimeTransformer implements TransformerInterface
{
    public const FORMAT_OPTION_NAME = 'format';
    public const FORCE_LOCAL_TIMEZONE_OPTION_NAME = 'forceLocalTimezone';
    public const DEFAULT_FORMAT = 'Y-m-d\TH:i:sP';
    public const DEFAULT_FORCE_LOCAL_TIMEZONE = true;

    public function transform($value, array $options)
    {
        $format = static::DEFAULT_FORMAT;
        if (isset($options[static::FORMAT_OPTION_NAME])) {
            $format = $options[static::FORMAT_OPTION_NAME];
        }

        $isForceLocalTimezone = static::DEFAULT_FORCE_LOCAL_TIMEZONE;
        if (isset($options[static::FORCE_LOCAL_TIMEZONE_OPTION_NAME])) {
            $isForceLocalTimezone = $options[static::FORCE_LOCAL_TIMEZONE_OPTION_NAME];
        }

        $result = \DateTime::createFromFormat($format, $value);
        if ($result === false) {
            throw new InvalidDateTimeFormatException($format);
        }

        if ($isForceLocalTimezone) {
            $dateTime = new \DateTime();
            $result->setTimezone($dateTime->getTimezone());
        }

        return $result;
    }
}
