<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\InvalidDateTimeException;
use Mapper\Exception\Transformer\InvalidDateTimeFormatException;

use function array_merge;
use function array_values;
use function implode;

class DateTimeTransformer extends StringTransformer
{
    public const FORMAT_OPTION_NAME = 'format';
    public const FORCE_LOCAL_TIMEZONE_OPTION_NAME = 'forceLocalTimezone';
    public const DEFAULT_FORMAT = 'Y-m-d\TH:i:sP';
    public const DEFAULT_FORCE_LOCAL_TIMEZONE = true;

    public function transform($value, array $options = [])
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

        $lastErrors = \DateTime::getLastErrors();
        if ($lastErrors['warning_count'] || $lastErrors['error_count']) {
            $errorMessage = implode(', ', array_merge(array_values($lastErrors['warnings']), array_values($lastErrors['errors'])));

            throw new InvalidDateTimeException($errorMessage);
        }

        if ($isForceLocalTimezone) {
            $dateTime = new \DateTime();
            $result->setTimezone($dateTime->getTimezone());
        }

        return $result;
    }
}
