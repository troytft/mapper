<?php

namespace Mapper\Transformer;

interface TransformerInterface
{
    public function transform($value, array $options);
}
