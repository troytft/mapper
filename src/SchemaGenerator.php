<?php

namespace Mapper;

use function get_class;
use function is_bool;
use Doctrine\Common\Annotations\AnnotationReader;

class SchemaGenerator
{
    /**
     * @var DTO\MapperSettings
     */
    private $settings;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @param DTO\MapperSettings $settings
     */
    public function __construct(DTO\MapperSettings $settings)
    {
        $this->settings = $settings;
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * @param ModelInterface $model
     *
     * @return array
     */
    public function generate(ModelInterface $model): array
    {
        return $this->processObject(new Annotation\ObjectType(), $model);
    }

    /**
     * @param DTO\Type\ObjectTypeInterface $type
     * @param $model
     * @param $rawValue
     *
     * @return array
     */
    private function processObject(DTO\Type\ObjectTypeInterface $type, ModelInterface $model)
    {
        $schema = [
            'type' => DTO\Type\ObjectTypeInterface::class,
            'class' => get_class($model),
            'isNullable' => $this->resolveIsNullable($type),
            'properties' => [],
        ];

        $reflectionClass = new \ReflectionClass($model);

        foreach ($reflectionClass->getProperties() as $property) {
            $annotation = $this->annotationReader->getPropertyAnnotation($property, DTO\Type\TypeInterface::class);
            if (!$annotation instanceof DTO\Type\TypeInterface) {
                continue;
            }

            $schema['properties'][$property->getName()] = $this->processType($annotation);
        }

        return $schema;
    }

    /**
     * @param DTO\Type\ScalarTypeInterface $type
     *
     * @return array
     */
    private function processScalar(DTO\Type\ScalarTypeInterface $type)
    {
        return [
            'type' => DTO\Type\ScalarTypeInterface::class,
            'isNullable' => $this->resolveIsNullable($type),
        ];
    }

    /**
     * @param DTO\Type\CollectionTypeInterface $type
     *
     * @return array
     */
    private function processCollection(DTO\Type\CollectionTypeInterface $type): array
    {
        return [
            'type' => DTO\Type\CollectionTypeInterface::class,
            'isNullable' => $this->resolveIsNullable($type),
            'items' => $this->processType($type->getType())
        ];
    }

    /**
     * @param DTO\Type\TypeInterface $type
     *
     * @return array
     */
    private function processType(DTO\Type\TypeInterface $type): array
    {
        switch (true) {
            case $type instanceof DTO\Type\ObjectTypeInterface:
                $className = $type->getClassName();
                $schema = $this->processObject($type, new $className);

                break;

            case $type instanceof DTO\Type\ScalarTypeInterface:
                $schema = $this->processScalar($type);

                break;

            case $type instanceof DTO\Type\CollectionTypeInterface:
                $schema = $this->processCollection($type);

                break;

            default:
                throw new \InvalidArgumentException();
        }

        return $schema;
    }

    /**
     * @param DTO\Type\TypeInterface $type
     *
     * @return bool
     */
    private function resolveIsNullable(DTO\Type\TypeInterface $type): bool
    {
        return is_bool($type->getIsNullable()) ? $type->getIsNullable() : $this->settings->getIsPropertiesNullableByDefault();
    }
}
