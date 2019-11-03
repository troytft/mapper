<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\BooleanRequiredException;

class BooleanTransformer implements TransformerInterface
{
    public function transform($value, array $options = [])
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($value === null) {
            throw new BooleanRequiredException();
        }

        return $value;
    }
}
