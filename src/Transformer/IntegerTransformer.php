<?php

namespace RequestModelBundle\Transformer;

use function is_integer;
use RequestModelBundle\Exception\FieldException;

class IntegerTransformer implements TransformerInterface
{
    /**
     * @param mixed $value
     *
     * @return string|null
     */
    public function transform($value): ?string
    {
        if (!is_integer($value)) {
            throw new FieldException('Value should be integer');
        }

        return $value;
    }
}
