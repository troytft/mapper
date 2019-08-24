<?php

namespace Mapper\Exception;

class CollectionRequiredValidationException extends AbstractMappingValidationException
{
    /**
     * @param array $path
     */
    public function __construct(array $path)
    {
        parent::__construct('Value should be collection', $path);
    }
}
