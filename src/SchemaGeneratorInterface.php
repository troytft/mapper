<?php

namespace Mapper;

interface SchemaGeneratorInterface
{
    public function getSchemaByClassInstance(ModelInterface $model): DTO\Schema\ObjectType;
    public function getSchemaByClassName(string $className): DTO\Schema\ObjectType;
    public function isModelHasProperty(ModelInterface $model, string $name): bool;
}
