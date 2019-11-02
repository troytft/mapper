<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\InvalidDateFormatException;

class DateTransformer implements TransformerInterface
{
    public const FORMAT_OPTION_NAME = 'format';
    public const DEFAULT_FORMAT = 'Y-m-d';

    public function transform($value, array $options)
    {
        $format = static::DEFAULT_FORMAT;
        if (isset($options[static::FORMAT_OPTION_NAME])) {
            $format = $options[static::FORMAT_OPTION_NAME];
        }

        $result = \DateTime::createFromFormat($format, $value);
        if ($result === false) {
            throw new InvalidDateFormatException($format);
        }

        $result->setTime(0, 0);

        return $result;
    }
}
