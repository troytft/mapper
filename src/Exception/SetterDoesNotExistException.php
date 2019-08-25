<?php

namespace Mapper\Exception;

use function sprintf;

class SetterDoesNotExistException extends \Exception implements ExceptionInterface
{
    /**
     * @var string
     */
    private $setterName;

    /**
     * @param string $setterName
     */
    public function __construct(string $setterName)
    {
        $this->setterName = $setterName;

        parent::__construct(sprintf('Setter with name "%s" does not exist.', $this->setterName));
    }

    /**
     * @return string
     */
    public function getSetterName(): string
    {
        return $this->setterName;
    }
}
