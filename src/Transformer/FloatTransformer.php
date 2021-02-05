<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\FloatRequiredException;

use function filter_var;
use function is_numeric;

class FloatTransformer implements TransformerInterface
{
    public static function getName(): string
    {
        return static::class;
    }

    public function transform($value, array $options = [])
    {
        if (!is_numeric($value)) {
            throw new FloatRequiredException();
        }

        $value = filter_var($value, FILTER_VALIDATE_FLOAT);
        if ($value === false) {
            throw new FloatRequiredException();
        }

        return $value;
    }
}
