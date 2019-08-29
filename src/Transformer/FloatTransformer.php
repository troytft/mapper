<?php

namespace Mapper\Transformer;

use function is_float;
use Mapper\Exception\Transformer\TransformerException;

class FloatTransformer implements TransformerInterface
{
    /**
     * @param $value
     * @param array $options
     * @return float
     * @throws TransformerException
     */
    public function transform($value, array $options)
    {
        if (!is_float($value)) {
            throw new TransformerException('Value must be float.');
        }

        return $value;
    }
}
