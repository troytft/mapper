<?php

namespace Mapper\Transformer;

use function is_bool;
use Mapper\Exception\Transformer\BooleanRequiredException;

class BooleanTransformer implements TransformerInterface
{
    /**
     * @param $value
     * @param array $options
     *
     * @return bool
     * @throws BooleanRequiredException
     */
    public function transform($value, array $options)
    {
        if (!is_bool($value)) {
            throw new BooleanRequiredException();
        }

        return $value;
    }
}
