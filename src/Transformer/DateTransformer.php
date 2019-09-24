<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\DateWithFormatRequiredException;

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
     * @throws DateWithFormatRequiredException
     */
    public function transform($value, array $options)
    {
        $result = \DateTime::createFromFormat($this->format, $value);
        if ($result === false) {
            throw new DateWithFormatRequiredException($this->format);
        }

        $result->setTime(0, 0);

        return $result;
    }
}
