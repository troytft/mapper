<?php

namespace RequestModelBundle\Annotation;

interface ScalarTypeInterface extends TypeInterface
{
    /**
     * @return string
     */
    public function getTransformer(): string;

    /**
     * @return array
     */
    public function getTransformerOptions(): array;
}
