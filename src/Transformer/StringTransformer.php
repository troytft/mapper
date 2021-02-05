<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\StringRequiredException;

use function is_string;

class StringTransformer implements TransformerInterface
{
    public static function getName(): string
    {
        return static::class;
    }

    public function transform($value, array $options = [])
    {
        if (!is_string($value)) {
            throw new StringRequiredException();
        }

        return $value;
    }
}
