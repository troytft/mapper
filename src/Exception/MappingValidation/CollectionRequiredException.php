<?php

namespace Mapper\Exception\MappingValidation;

class CollectionRequiredException extends AbstractMappingValidationException
{
    /**
     * @param array $path
     */
    public function __construct(array $path)
    {
        parent::__construct('Value should be collection', $path);
    }
}
