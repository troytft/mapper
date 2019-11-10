<?php

namespace Mapper\Transformer;

interface TransformerInterface
{
    public static function getName(): string;
    public function transform($value, array $options);
}
