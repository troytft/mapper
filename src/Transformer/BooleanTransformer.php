<?php

namespace RequestModelBundle\Transformer;

use function is_bool;
use RequestModelBundle\Exception\FieldException;

class BooleanTransformer implements TransformerInterface
{
    /**
     * @param mixed $value
     *
     * @return string|null
     */
    public function transform($value): ?string
    {
        if (!is_bool($value)) {
            throw new FieldException('Value should be boolean');
        }

        return $value;
    }
}
