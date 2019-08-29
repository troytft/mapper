<?php

namespace Mapper\Transformer;

use function is_integer;
use Mapper\Exception\Transformer\TransformerException;

class IntegerTransformer implements TransformerInterface
{
    /**
     * @param $value
     * @param array $options
     * @return int
     * @throws TransformerException
     */
    public function transform($value, array $options)
    {
        if (!is_integer($value)) {
            throw new TransformerException('Value must be integer.');
        }

        return $value;
    }
}
