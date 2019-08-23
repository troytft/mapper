<?php

namespace RequestModelBundle\Transformer;

use RequestModelBundle\Exception\FieldException;
use function is_string;

class StringTransformer implements TransformerInterface
{
    /**
     * @param mixed $value
     *
     * @return string|null
     */
    public function transform($value): ?string
    {
        if ($value === null) {
            return $value;
        }

        if (!is_string($value)) {
            throw new FieldException('Value should be string');
        }

        return $value;
    }
}
