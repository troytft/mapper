<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\BooleanRequiredException;
use function is_bool;

class BooleanTransformer implements TransformerInterface
{
    public function transform($value, array $options = [])
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (!is_bool($value)) {
            throw new BooleanRequiredException();
        }

        return $value;
    }
}
