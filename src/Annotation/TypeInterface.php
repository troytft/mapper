<?php

namespace RequestModelBundle\Annotation;

interface TypeInterface
{
    /**
     * @return bool|null
     */
    public function getIsNullable(): ?bool;
}
