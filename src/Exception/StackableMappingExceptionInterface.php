<?php

namespace Mapper\Exception;

interface StackableMappingExceptionInterface extends \Throwable
{
    public function getPath(): array;
    public function getPathAsString(): string;
}
