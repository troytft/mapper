<?php

namespace Mapper\Exception;

interface PathAwareExceptionInterface
{
    public function getPath(): array;
    public function getPathAsString(): string;
}
