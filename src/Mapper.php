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
     * @var DTO\Settings
     */
    private $settings;

    /**
     * @var SchemaGenerator
     */
    private $schemaGenerator;

    /**
     * @param DTO\Settings $settings
     */
    public function __construct(DTO\Settings $settings)
    {
        $this->settings = $settings;
        $this->schemaGenerator = new SchemaGenerator($settings);
    }

    /**
     * @return DTO\Settings
     */
    public function getSettings(): DTO\Settings
    {
        return $this->settings;
    }

    /**
     * @param DTO\Settings $settings
     *
     * @return $this
     */
    public function setSettings(DTO\Settings $settings)
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
        $this->mapObject($schema, $model, $data, []);
    }

    /**
     * @param DTO\Schema\ObjectTypeInterface $schema
     * @param ModelInterface $model
     * @param $rawValue
     * @param array $basePath
     *
     * @return ModelInterface
     */
    private function mapObject(DTO\Schema\ObjectTypeInterface $schema, ModelInterface $model, $rawValue, array $basePath): ModelInterface
    {
        if (!is_array($rawValue) || $this->isPlainArray($rawValue)) {
            throw new Exception\MappingValidation\ObjectRequiredException($basePath);
        }

        foreach ($rawValue as $propertyName => $propertyValue) {
            $path = $basePath;
            $path[] = $propertyName;

            if (!isset($schema->getProperties()[$propertyName])) {
                if ($this->settings->getIsAllowedUndefinedKeysInData()) {
                    continue;
                } else {
                    throw new Exception\MappingValidation\UndefinedKeyException($path);
                }
            }

            $propertySchema = $schema->getProperties()[$propertyName];
            $setterName = 'set' . ucfirst($propertyName);

            $mappedValue = $this->mapType($propertySchema, $propertyValue, $path);
            call_user_func([$model, $setterName], $mappedValue);
        }

        $notPresentedProperties = array_diff(array_keys($schema->getProperties()), array_keys($rawValue));
        foreach ($notPresentedProperties as $propertyName) {
            $propertySchema = $schema->getProperties()[$propertyName];
            if ($propertySchema->getIsNullable()) {
                continue;
            }

            $path = $basePath;
            $path[] = $propertyName;

            switch (true) {
                case $propertySchema instanceof DTO\Schema\ScalarTypeInterface:
                    throw new Exception\MappingValidation\ScalarRequiredException($path);

                    break;

                case $propertySchema instanceof DTO\Schema\ObjectTypeInterface:
                    throw new Exception\MappingValidation\ObjectRequiredException($path);

                    break;

                case $propertySchema instanceof DTO\Schema\CollectionTypeInterface:
                    throw new Exception\MappingValidation\CollectionRequiredException($path);

                    break;

                default:
                    throw new \InvalidArgumentException();
            }
        }

        return $model;
    }

    /**
     * @param DTO\Schema\TypeInterface $schema
     * @param mixed|null $rawValue
     * @param array $basePath
     * @return mixed|null
     */
    private function mapType(DTO\Schema\TypeInterface $schema, $rawValue, array $basePath)
    {
        if ($schema->getIsNullable() && $rawValue === null) {
            return null;
        }

        switch (true) {
            case $schema instanceof DTO\Schema\ScalarTypeInterface:
                $value = $this->mapScalarType($schema, $rawValue, $basePath);

                break;

            case $schema instanceof DTO\Schema\ObjectTypeInterface:
                $class = $schema->getClass();
                $value = $this->mapObject($schema, new $class, $rawValue, $basePath);

                break;

            case $schema instanceof DTO\Schema\CollectionTypeInterface:
                $value = $this->mapCollectionType($schema, $rawValue, $basePath);

                break;

            default:
                throw new \InvalidArgumentException();

        }

        return $value;
    }

    /**
     * @param DTO\Schema\ScalarTypeInterface $schema
     * @param mixed $rawValue
     * @param array $basePath
     *
     * @return mixed
     */
    private function mapScalarType(DTO\Schema\ScalarTypeInterface $schema, $rawValue, array $basePath)
    {
        if (!is_scalar($rawValue)) {
            throw new Exception\MappingValidation\ScalarRequiredException($basePath);
        }

        return $rawValue;
    }

    /**
     * @param DTO\Schema\CollectionTypeInterface $schema
     * @param mixed $rawValue
     * @param array $basePath
     *
     * @return array
     * @throws Exception\MappingValidation\CollectionRequiredException
     */
    private function mapCollectionType(DTO\Schema\CollectionTypeInterface $schema, $rawValue, array $basePath): array
    {
        if (!is_array($rawValue) || !$this->isPlainArray($rawValue)) {
            throw new Exception\MappingValidation\CollectionRequiredException($basePath);
        }

        $value = [];

        foreach ($rawValue as $i => $item) {
            $path = $basePath;
            $path[] = $i;

            $value[] = $this->mapType($schema->getItems(), $item, $path);
        }

        return $value;
    }

    /**
     * @param array $array
     *
     * @return bool
     */
    private function isPlainArray(array $array): bool
    {
        return empty($array) || array_keys($array) === range(0, count($array) - 1);
    }
}
