<?php

namespace Mapper\Transformer;

use function is_bool;
use Mapper\Exception\Transformer\TransformerException;

class BooleanTransformer implements TransformerInterface
{
    /**
     * @param $value
     * @param array $options
     * @return bool
     * @throws TransformerException
     */
    public function transform($value, array $options)
    {
        if (!is_bool($value)) {
            throw new TransformerException('Value must be boolean.');
        }

        return $value;
    }
}
