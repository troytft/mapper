<?php

namespace RequestModelBundle;

use function get_class;
use function is_bool;
use function is_scalar;
use RequestModelBundle\Annotation\ObjectType;
use RequestModelBundle\Annotation\TypeInterface;
use RequestModelBundle\Annotation\CollectionTypeInterface;
use RequestModelBundle\Annotation\ObjectTypeInterface;
use RequestModelBundle\Annotation\ScalarTypeInterface;
use RequestModelBundle\Exception\CollectionRequiredException;
use RequestModelBundle\Exception\ScalarRequiredException;
use Doctrine\Common\Annotations\AnnotationReader;
use function call_user_func;
use function sprintf;
use function ucfirst;
use function var_dump;

class DataMapper
{
    private const DEFAULT_IS_NULLABLE = false;
    private const ALLOW_UNDEFINED_KEYS_IN_DATA = true;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;


    /**
     * @param AnnotationReader $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }


    public function map(RequestModelInterface $model, array $data)
    {
        $schema = $this->processObjectTypeScheme(new ObjectType(), $model);
        $this->getProcessedObjectValue($schema, $model, $data, []);
        var_dump($model);die();
    }

    private function getProcessedObjectValue(array $schema, $model, $data, array $basePath)
    {
        foreach ($data as $key => $rawValue) {
            if (!isset($schema['properties'][$key])) {
                if (static::ALLOW_UNDEFINED_KEYS_IN_DATA) {
                    continue;
                } else {
                    throw new \InvalidArgumentException(sprintf('Undefined key "%s"', $key));
                }
            }

            $path = $basePath;
            $path[] = $key;

            $propertySchema = $schema['properties'][$key];
            $setterName = 'set' . ucfirst($key);

            $processedValue = $this->getProcessedValue($propertySchema, $rawValue, $path);
            call_user_func([$model, $setterName], $processedValue);
        }

        return $model;
    }

    private function getProcessedValue($propertySchema, $rawValue, array $basePath)
    {
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
        if ($propertySchema['isNullable'] && $rawValue === null) {
            return null;
        }

        if (!is_scalar($rawValue)) {
            throw new ScalarRequiredException($basePath);
        }

        return $rawValue;
    }

    private function getProcessedCollectionValue($propertySchema, $rawValue, array $basePath): array
    {
        if (!$this->isPlainArray($rawValue)) {
            throw new CollectionRequiredException($basePath);
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
    private function processObjectTypeScheme(ObjectTypeInterface $type, RequestModelInterface $model)
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
        return is_bool($type->getIsNullable()) ? $type->getIsNullable() : static::DEFAULT_IS_NULLABLE;
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
