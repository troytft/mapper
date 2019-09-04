<?php

namespace Mapper\Transformer;

use function is_integer;
use Mapper\Exception\Transformer\IntegerRequiredException;

class IntegerTransformer implements TransformerInterface
{
    /**
     * @param $value
     * @param array $options
     *
     * @return int
     * @throws IntegerRequiredException
     */
    public function transform($value, array $options)
    {
        if (!is_integer($value)) {
            throw new IntegerRequiredException();
        }

        return $value;
    }
}
