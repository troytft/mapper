<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\IntegerRequiredException;

class TimestampTransformer extends IntegerTransformer
{
    /**
     * @param $value
     * @param array $options
     *
     * @return \DateTime
     * @throws IntegerRequiredException
     */
    public function transform($value, array $options)
    {
        $timestamp = parent::transform($value, []);

        $result = new \DateTime();
        $result->setTimestamp($timestamp);

        return $result;
    }
}
