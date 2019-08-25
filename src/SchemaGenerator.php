<?php

namespace Mapper;

use function get_class;
use function is_bool;
use Doctrine\Common\Annotations\AnnotationReader;

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
        return $this->processObjectType(new Annotation\ObjectType(), $model);
    }

    /**
     * @param DTO\Mapping\ObjectTypeInterface $type
     * @param $model
     * @param $rawValue
     *
     * @return DTO\Schema\ObjectType
     */
    private function processObjectType(DTO\Mapping\ObjectTypeInterface $type, ModelInterface $model): DTO\Schema\ObjectType
    {
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
            ->setClass(get_class($model))
            ->setIsNullable($this->resolveIsNullable($type))
            ->setProperties($properties);

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
            ->setIsNullable($this->resolveIsNullable($type));

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
            ->setIsNullable($this->resolveIsNullable($type));

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
    private function resolveIsNullable(DTO\Mapping\TypeInterface $type): bool
    {
        return is_bool($type->getIsNullable()) ? $type->getIsNullable() : $this->settings->getIsPropertiesNullableByDefault();
    }
}
