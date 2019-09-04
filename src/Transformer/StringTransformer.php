<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\StringRequiredException;
use function is_string;

class StringTransformer implements TransformerInterface
{
    /**
     * @param $value
     * @param array $options
     *
     * @return string
     * @throws StringRequiredException
     */
    public function transform($value, array $options)
    {
        if (!is_string($value)) {
            throw new StringRequiredException();
        }

        return $value;
    }
}
