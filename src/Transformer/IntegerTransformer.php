<?php

namespace Mapper\Transformer;

use function is_integer;
use Mapper\Exception\Transformer\IntegerRequiredException;

class IntegerTransformer implements TransformerInterface
{
    public function transform($value, array $options)
    {
        if (!is_integer($value)) {
            throw new IntegerRequiredException();
        }

        return $value;
    }
}
