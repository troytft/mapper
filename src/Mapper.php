<?php

namespace Mapper;

use function array_diff;
use function array_keys;
use function is_array;
use function is_scalar;
use function call_user_func;
use function ucfirst;

class Mapper
{
    /**
     * @var DTO\MapperSettings
     */
    private $settings;

    /**
     * @var SchemaGenerator
     */
    private $schemaGenerator;

    /**
     * @param DTO\MapperSettings $settings
     */
    public function __construct(DTO\MapperSettings $settings)
    {
        $this->settings = $settings;
        $this->schemaGenerator = new SchemaGenerator($settings);
    }

    /**
     * @return DTO\MapperSettings
     */
    public function getSettings(): DTO\MapperSettings
    {
        return $this->settings;
    }

    /**
     * @param DTO\MapperSettings $settings
     *
     * @return $this
     */
    public function setSettings(DTO\MapperSettings $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * @param ModelInterface $model
     * @param array $data
     *
     * @throws Exception\MappingValidation\AbstractMappingValidationException
     */
    public function map(ModelInterface $model, array $data)
    {
        $schema = $this->schemaGenerator->generate($model);
        $this->getProcessedObjectValue($schema, $model, $data, []);
    }

    private function getProcessedObjectValue(array $schema, $model, $rawValue, array $basePath)
    {
        if (!is_array($rawValue) || $this->isPlainArray($rawValue)) {
            throw new Exception\MappingValidation\ObjectRequiredException($basePath);
        }

        foreach ($rawValue as $propertyName => $propertyValue) {
            $path = $basePath;
            $path[] = $propertyName;

            if (!isset($schema['properties'][$propertyName])) {
                if ($this->settings->getIsAllowedUndefinedKeysInData()) {
                    continue;
                } else {
                    throw new Exception\MappingValidation\UndefinedKeyException($path);
                }
            }

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

            switch ($propertySchema['type']) {
                case DTO\Type\ScalarTypeInterface::class:
                    throw new Exception\MappingValidation\ScalarRequiredException($path);

                    break;

                case DTO\Type\ObjectTypeInterface::class:
                    throw new Exception\MappingValidation\ObjectRequiredException($path);

                    break;

                case DTO\Type\CollectionTypeInterface::class:
                    throw new Exception\MappingValidation\CollectionRequiredException($path);

                    break;

                default:
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

        switch ($propertySchema['type']) {
            case DTO\Type\ScalarTypeInterface::class:
                $value = $this->getProcessedScalarValue($propertySchema, $rawValue, $basePath);

                break;

            case DTO\Type\ObjectTypeInterface::class:
                $propertyModel = new $propertySchema['class'];
                $value = $this->getProcessedObjectValue($propertySchema, $propertyModel, $rawValue, $basePath);

                break;

            case DTO\Type\CollectionTypeInterface::class:
                $value = $this->getProcessedCollectionValue($propertySchema, $rawValue, $basePath);

                break;

            default:
                throw new \InvalidArgumentException();

        }

        return $value;
    }

    private function getProcessedScalarValue($propertySchema, $rawValue, $basePath)
    {
        if (!is_scalar($rawValue)) {
            throw new Exception\MappingValidation\ScalarRequiredException($basePath);
        }

        return $rawValue;
    }

    private function getProcessedCollectionValue($propertySchema, $rawValue, array $basePath): array
    {
        if (!is_array($rawValue) || !$this->isPlainArray($rawValue)) {
            throw new Exception\MappingValidation\CollectionRequiredException($basePath);
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
     * @param array $array
     *
     * @return bool
     */
    public function isPlainArray(array $array): bool
    {
        return empty($array) || array_keys($array) === range(0, count($array) - 1);
    }
}
