<?php

namespace Mapper\Transformer;

use function is_float;
use Mapper\Exception\Transformer\FloatRequiredException;

class FloatTransformer implements TransformerInterface
{
    /**
     * @param $value
     * @param array $options
     *
     * @return float
     * @throws FloatRequiredException
     */
    public function transform($value, array $options)
    {
        if (!is_float($value)) {
            throw new FloatRequiredException();
        }

        return $value;
    }
}
