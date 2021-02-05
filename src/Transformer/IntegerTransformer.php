<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\IntegerRequiredException;

use function filter_var;
use function is_numeric;

class IntegerTransformer implements TransformerInterface
{
    public static function getName(): string
    {
        return static::class;
    }

    public function transform($value, array $options = [])
    {
        if (!is_numeric($value)) {
            throw new IntegerRequiredException();
        }

        $value = filter_var($value, FILTER_VALIDATE_INT);
        if ($value === false) {
            throw new IntegerRequiredException();
        }

        return $value;
    }
}
