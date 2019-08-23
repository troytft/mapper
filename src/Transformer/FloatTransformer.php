<?php

namespace RequestModelBundle\Transformer;

use function is_float;
use RequestModelBundle\Exception\FieldException;

class FloatTransformer implements TransformerInterface
{
    /**
     * @param mixed $value
     *
     * @return float|null
     */
    public function transform($value): ?float
    {
        if (!is_float($value)) {
            throw new FieldException('Value should be float');
        }

        return $value;
    }
}
