<?php

namespace RequestModelBundle\Transformer;

interface TransformerInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function transform($value);
}
