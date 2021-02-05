<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\BooleanRequiredException;

use function is_bool;
use function is_string;

class BooleanTransformer implements TransformerInterface
{
    public static function getName(): string
    {
        return static::class;
    }

    public function transform($value, array $options = [])
    {
        if (!is_bool($value) && !is_string($value)) {
            throw new BooleanRequiredException();
        }

        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (!is_bool($value)) {
            throw new BooleanRequiredException();
        }

        return $value;
    }
}
