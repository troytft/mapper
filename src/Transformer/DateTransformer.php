<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\InvalidDateException;
use Mapper\Exception\Transformer\InvalidDateFormatException;

class DateTransformer extends StringTransformer
{
    public const FORMAT_OPTION_NAME = 'format';
    public const DEFAULT_FORMAT = 'Y-m-d';

    public function transform($value, array $options = [])
    {
        $format = static::DEFAULT_FORMAT;
        if (isset($options[static::FORMAT_OPTION_NAME])) {
            $format = $options[static::FORMAT_OPTION_NAME];
        }

        $result = \DateTime::createFromFormat($format, $value);
        if ($result === false) {
            throw new InvalidDateFormatException($format);
        }

        $lastErrors = \DateTime::getLastErrors();
        if ($lastErrors['warning_count'] || $lastErrors['error_count']) {
            $errorMessage = implode(', ', array_merge(array_values($lastErrors['warnings']), array_values($lastErrors['errors'])));

            throw new InvalidDateException($errorMessage);
        }

        $result->setTime(0, 0);

        return $result;
    }
}
