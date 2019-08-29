<?php

namespace Mapper\Transformer;

use Mapper\Exception\Transformer\TransformerException;
use function is_string;
use function var_dump;

class StringTransformer implements TransformerInterface
{
    /**
     * @param $value
     * @param array $options
     * @return string
     * @throws TransformerException
     */
    public function transform($value, array $options)
    {
        if (!is_string($value)) {
            throw new TransformerException('Value must be string.');
        }

        return $value;
    }
}
