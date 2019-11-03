<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\IntegerRequiredException;
use function filter_var;

class IntegerTransformer implements TransformerInterface
{
    public function transform($value, array $options = [])
    {
        $value = filter_var($value, FILTER_VALIDATE_INT);
        
        if ($value === false) {
            throw new IntegerRequiredException();
        }

        return $value;
    }
}
