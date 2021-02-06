<?php

namespace Mapper\Exception;

interface PathAwareExceptionInterface extends \Throwable
{
    public function getPath(): array;
    public function getPathAsString(): string;
}
