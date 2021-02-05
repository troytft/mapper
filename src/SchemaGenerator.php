<?php

namespace Mapper;

use Doctrine\Common\Annotations\AnnotationReader;

use function get_class;
use function is_bool;

class SchemaGenerator
{
    /**
     * @var DTO\Settings
     */
    private $settings;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @var DTO\Schema\ObjectType[]
     */
    private $schemaCache;

    public function __construct(DTO\Settings $settings)
    {
        $this->settings = $settings;
        $this->annotationReader = Helper\AnnotationReaderFactory::create(true);
    }

    /**
     * @deprecated use getSchemaByClassInstance instead
     */
    public function generate(ModelInterface $model): DTO\Schema\ObjectType
    {
        return $this->getSchemaByClassInstance($model);
    }

    public function getSchemaByClassInstance(ModelInterface $model): DTO\Schema\ObjectType
    {
        return $this->processObjectType(new Annotation\ObjectType(), get_class($model));
    }

    public function getSchemaByClassName(string $className): DTO\Schema\ObjectType
    {
        return $this->processObjectType(new Annotation\ObjectType(), $className);
    }

    private function processObjectType(DTO\Mapping\ObjectTypeInterface $mapping, string $className): DTO\Schema\ObjectType
    {
        $className = ltrim($className, '\\');

        if (isset($this->schemaCache[$className])) {
            return $this->schemaCache[$className];
        }

        $properties = [];
        $reflectionClass = new \ReflectionClass($className);

        foreach ($reflectionClass->getProperties() as $property) {
            $annotation = $this->annotationReader->getPropertyAnnotation($property, DTO\Mapping\TypeInterface::class);
            if (!$annotation instanceof DTO\Mapping\TypeInterface) {
                continue;
            }

            $properties[$property->getName()] = $this->processType($annotation);
        }

        $schema = new DTO\Schema\ObjectType();
        $schema
            ->setClassName($className)
            ->setNullable($this->resolveNullable($mapping))
            ->setProperties($properties)
            ->setTransformerName($mapping->getTransformerName())
            ->setTransformerOptions($mapping->getTransformerOptions());

        $this->schemaCache[$className] = $schema;

        return $schema;
    }

    private function processScalarType(DTO\Mapping\ScalarTypeInterface $type): DTO\Schema\ScalarType
    {
        $schema = new DTO\Schema\ScalarType();
        $schema
            ->setNullable($this->resolveNullable($type))
            ->setTransformerName($type->getTransformerName())
            ->setTransformerOptions($type->getTransformerOptions());

        return $schema;
    }

    private function processCollectionType(DTO\Mapping\CollectionTypeInterface $type): DTO\Schema\CollectionType
    {
        $schema = new DTO\Schema\CollectionType();
        $schema
            ->setItems($this->processType($type->getType()))
            ->setNullable($this->resolveNullable($type))
            ->setTransformerName($type->getTransformerName())
            ->setTransformerOptions($type->getTransformerOptions());

        return $schema;
    }

    private function processType(DTO\Mapping\TypeInterface $type): DTO\Schema\TypeInterface
    {
        switch (true) {
            case $type instanceof DTO\Mapping\ObjectTypeInterface:
                $schema = $this->processObjectType($type, $type->getClassName());

                break;

            case $type instanceof DTO\Mapping\ScalarTypeInterface:
                $schema = $this->processScalarType($type);

                break;

            case $type instanceof DTO\Mapping\CollectionTypeInterface:
                $schema = $this->processCollectionType($type);

                break;

            default:
                throw new \InvalidArgumentException();
        }

        return $schema;
    }

    private function resolveNullable(DTO\Mapping\TypeInterface $type): bool
    {
        return is_bool($type->getNullable()) ? $type->getNullable() : $this->settings->getIsPropertiesNullableByDefault();
    }

    public function isModelHasProperty(ModelInterface $model, string $name): bool
    {
        return isset($this->generate($model)->getProperties()[$name]);
    }
}
