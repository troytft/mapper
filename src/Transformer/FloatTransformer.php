<?php

namespace Mapper\Transformer;

use function is_float;
use Mapper\Exception\Transformer\FloatRequiredException;

class FloatTransformer implements TransformerInterface
{
    public function transform($value, array $options)
    {
        if (!is_float($value)) {
            throw new FloatRequiredException();
        }

        return $value;
    }
}
