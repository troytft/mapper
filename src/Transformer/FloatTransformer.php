<?php

namespace Mapper\Transformer;

use function filter_var;
use Mapper\Exception\Transformer\FloatRequiredException;

class FloatTransformer implements TransformerInterface
{
    public function transform($value, array $options = [])
    {
        $value = filter_var($value, FILTER_VALIDATE_FLOAT);

        if ($value === false) {
            throw new FloatRequiredException();
        }

        return $value;
    }
}
