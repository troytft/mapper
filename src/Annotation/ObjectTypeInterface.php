<?php

namespace Mapper\Annotation;

interface ObjectTypeInterface extends TypeInterface
{
    /**
     * @return string
     */
    public function getClassName(): string;
}
