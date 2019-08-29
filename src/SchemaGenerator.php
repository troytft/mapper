<?php

namespace Mapper;

use function get_class;
use function is_bool;
use Doctrine\Common\Annotations\AnnotationReader;
use function var_dump;

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
     * @var DTO\Schema\TypeInterface[]
     */
    private $modelSchemasCache;

    /**
     * @param DTO\Settings $settings
     */
    public function __construct(DTO\Settings $settings)
    {
        $this->settings = $settings;
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * @param ModelInterface $model
     *
     * @return DTO\Schema\ObjectType
     */
    public function generate(ModelInterface $model): DTO\Schema\ObjectType
    {
        $this->modelSchemasCache = [];

        return $this->processObjectType(new Annotation\ObjectType(), $model);
    }

    /**
     * @param DTO\Mapping\ObjectTypeInterface $type
     * @param ModelInterface $model
     *
     * @return DTO\Schema\ObjectType
     */
    private function processObjectType(DTO\Mapping\ObjectTypeInterface $type, ModelInterface $model): DTO\Schema\ObjectType
    {
        $class = get_class($model);

        if (isset($this->modelSchemasCache[$class])) {
            return $this->modelSchemasCache[$class];
        }

        $properties = [];
        $reflectionClass = new \ReflectionClass($model);

        foreach ($reflectionClass->getProperties() as $property) {
            $annotation = $this->annotationReader->getPropertyAnnotation($property, DTO\Mapping\TypeInterface::class);
            if (!$annotation instanceof DTO\Mapping\TypeInterface) {
                continue;
            }

            $properties[$property->getName()] = $this->processType($annotation);
        }

        $schema = new DTO\Schema\ObjectType();
        $schema
            ->setClass($class)
            ->setNullable($this->resolveNullable($type))
            ->setProperties($properties);

        $this->modelSchemasCache[$class] = $schema;

        return $schema;
    }

    /**
     * @param DTO\Mapping\ScalarTypeInterface $type
     *
     * @return DTO\Schema\ScalarType
     */
    private function processScalarType(DTO\Mapping\ScalarTypeInterface $type): DTO\Schema\ScalarType
    {
        $schema = new DTO\Schema\ScalarType();
        $schema
            ->setNullable($this->resolveNullable($type))
            ->setTransformer($type->getTransformer());

        return $schema;
    }

    /**
     * @param DTO\Mapping\CollectionTypeInterface $type
     *
     * @return DTO\Schema\CollectionType
     */
    private function processCollectionType(DTO\Mapping\CollectionTypeInterface $type): DTO\Schema\CollectionType
    {
        $schema = new DTO\Schema\CollectionType();
        $schema
            ->setItems($this->processType($type->getType()))
            ->setNullable($this->resolveNullable($type));

        return $schema;
    }

    /**
     * @param DTO\Mapping\TypeInterface $type
     *
     * @return DTO\Schema\TypeInterface
     */
    private function processType(DTO\Mapping\TypeInterface $type): DTO\Schema\TypeInterface
    {
        switch (true) {
            case $type instanceof DTO\Mapping\ObjectTypeInterface:
                $className = $type->getClassName();
                $schema = $this->processObjectType($type, new $className);

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

    /**
     * @param DTO\Mapping\TypeInterface $type
     *
     * @return bool
     */
    private function resolveNullable(DTO\Mapping\TypeInterface $type): bool
    {
        return is_bool($type->getNullable()) ? $type->getNullable() : $this->settings->getIsPropertiesNullableByDefault();
    }
}