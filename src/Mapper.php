<?php

namespace Mapper;

use function array_diff;
use function array_keys;
use function get_class;
use function is_array;
use function is_bool;
use function is_scalar;
use Mapper\Annotation\ObjectType;
use Mapper\Annotation\TypeInterface;
use Mapper\Annotation\CollectionTypeInterface;
use Mapper\Annotation\ObjectTypeInterface;
use Mapper\Annotation\ScalarTypeInterface;
use Mapper\DTO\MapperSettings;
use Mapper\Exception\AbstractMappingValidationException;
use Mapper\Exception\CollectionRequiredValidationException;
use Mapper\Exception\ObjectRequiredValidationException;
use Mapper\Exception\ScalarRequiredValidationException;
use Doctrine\Common\Annotations\AnnotationReader;
use function call_user_func;
use function sprintf;
use function ucfirst;

class Mapper
{
    /**
     * @var MapperSettings
     */
    private $settings;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @param MapperSettings $settings
     * @param AnnotationReader $annotationReader
     */
    public function __construct(MapperSettings $settings, AnnotationReader $annotationReader)
    {
        $this->settings = $settings;
        $this->annotationReader = $annotationReader;
    }

    /**
     * @return MapperSettings
     */
    public function getSettings(): MapperSettings
    {
        return $this->settings;
    }

    /**
     * @param MapperSettings $settings
     *
     * @return $this
     */
    public function setSettings(MapperSettings $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * @param ModelInterface $model
     * @param array $data
     *
     * @throws AbstractMappingValidationException
     */
    public function map(ModelInterface $model, array $data)
    {
        $schema = $this->processObjectTypeScheme(new ObjectType(), $model);
        $this->getProcessedObjectValue($schema, $model, $data, []);
    }

    private function getProcessedObjectValue(array $schema, $model, $rawValue, array $basePath)
    {
        if (!is_array($rawValue) || $this->isPlainArray($rawValue)) {
            throw new ObjectRequiredValidationException($basePath);
        }

        foreach ($rawValue as $propertyName => $propertyValue) {
            if (!isset($schema['properties'][$propertyName])) {
                if ($this->settings->getIsUndefinedKeysInDataAllowed()) {
                    continue;
                } else {
                    throw new \InvalidArgumentException(sprintf('Undefined key "%s"', $propertyName));
                }
            }

            $path = $basePath;
            $path[] = $propertyName;

            $propertySchema = $schema['properties'][$propertyName];
            $setterName = 'set' . ucfirst($propertyName);

            $processedValue = $this->getProcessedValue($propertySchema, $propertyValue, $path);
            call_user_func([$model, $setterName], $processedValue);
        }

        $notPresentedProperties = array_diff(array_keys($schema['properties']), array_keys($rawValue));
        foreach ($notPresentedProperties as $propertyName) {
            $propertySchema = $schema['properties'][$propertyName];
            if ($propertySchema['isNullable']) {
                continue;
            }

            $path = $basePath;
            $path[] = $propertyName;

            if ($propertySchema['type'] === 'scalar') {
                throw new ScalarRequiredValidationException($path);
            } elseif ($propertySchema['type'] === 'object') {
                throw new ObjectRequiredValidationException($path);
            } elseif ($propertySchema['type'] === 'collection') {
                throw new CollectionRequiredValidationException($path);
            } else {
                throw new \InvalidArgumentException();
            }
        }

        return $model;
    }

    private function getProcessedValue($propertySchema, $rawValue, array $basePath)
    {
        if ($propertySchema['isNullable'] && $rawValue === null) {
            return null;
        }

        if ($propertySchema['type'] === 'scalar') {
            $value = $this->getProcessedScalarValue($propertySchema, $rawValue, $basePath);
        } elseif ($propertySchema['type'] === 'object') {
            $propertyModel = new $propertySchema['class'];
            $value = $this->getProcessedObjectValue($propertySchema, $propertyModel, $rawValue, $basePath);
        } elseif ($propertySchema['type'] === 'collection') {
            $value = $this->getProcessedCollectionValue($propertySchema, $rawValue, $basePath);
        } else {
            throw new \InvalidArgumentException();
        }

        return $value;
    }

    private function getProcessedScalarValue($propertySchema, $rawValue, $basePath)
    {
        if (!is_scalar($rawValue)) {
            throw new ScalarRequiredValidationException($basePath);
        }

        return $rawValue;
    }

    private function getProcessedCollectionValue($propertySchema, $rawValue, array $basePath): array
    {
        if (!is_array($rawValue) || !$this->isPlainArray($rawValue)) {
            throw new CollectionRequiredValidationException($basePath);
        }

        $value = [];

        foreach ($rawValue as $i => $item) {
            $path = $basePath;
            $path[] = $i;

            $value[] = $this->getProcessedValue($propertySchema['items'], $item, $path);
        }

        return $value;
    }

    /**
     * @param ObjectTypeInterface $type
     * @param $model
     * @param $rawValue
     *
     * @return array
     */
    private function processObjectTypeScheme(ObjectTypeInterface $type, ModelInterface $model)
    {
        $schema = [
            'type' => 'object',
            'class' => get_class($model),
            'isNullable' => $this->resolveIsNullable($type),
            'properties' => [],
        ];

        $reflectionClass = new \ReflectionClass($model);

        foreach ($reflectionClass->getProperties() as $property) {
            $annotation = $this->annotationReader->getPropertyAnnotation($property, TypeInterface::class);
            if (!$annotation instanceof TypeInterface) {
                continue;
            }

            $schema['properties'][$property->getName()] = $this->processTypeScheme($annotation);
        }

        return $schema;
    }

    private function processScalarTypeScheme(ScalarTypeInterface $type)
    {
        return [
            'type' => 'scalar',
            'isNullable' => $this->resolveIsNullable($type),
        ];
    }

    private function processCollectionTypeScheme(CollectionTypeInterface $type): array
    {
        return [
            'type' => 'collection',
            'isNullable' => $this->resolveIsNullable($type),
            'items' => $this->processTypeScheme($type->getType())
        ];
    }

    private function processTypeScheme(TypeInterface $type): array
    {
        if ($type instanceof ObjectTypeInterface) {
            $className = $type->getClassName();
            $schema = $this->processObjectTypeScheme($type, new $className);
        } elseif ($type instanceof ScalarTypeInterface) {
            $schema = $this->processScalarTypeScheme($type);
        } elseif ($type instanceof CollectionTypeInterface) {
            $schema = $this->processCollectionTypeScheme($type);
        } else {
            throw new \InvalidArgumentException();
        }

        return $schema;
    }

    /**
     * @param TypeInterface $type
     *
     * @return bool
     */
    private function resolveIsNullable(TypeInterface $type): bool
    {
        return is_bool($type->getIsNullable()) ? $type->getIsNullable() : $this->settings->getIsPropertiesNullableByDefault();
    }

    /**
     * @param array $array
     *
     * @return bool
     */
    public function isPlainArray(array $array): bool
    {
        return empty($array) || array_keys($array) === range(0, count($array) - 1);
    }
}
