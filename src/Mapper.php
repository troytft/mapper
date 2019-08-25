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
     * @param array $schema
     * @param ModelInterface $model
     * @param $rawValue
     * @param array $basePath
     * @return ModelInterface
     */
    private function mapObject(array $schema, ModelInterface $model, $rawValue, array $basePath)
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

            $mappedValue = $this->mapType($propertySchema, $propertyValue, $path);
            call_user_func([$model, $setterName], $mappedValue);
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

    /**
     * @param array $propertySchema
     * @param mixed|null $rawValue
     * @param array $basePath
     * @return mixed|null
     */
    private function mapType(array $propertySchema, $rawValue, array $basePath)
    {
        if ($propertySchema['isNullable'] && $rawValue === null) {
            return null;
        }

        switch ($propertySchema['type']) {
            case DTO\Type\ScalarTypeInterface::class:
                $value = $this->mapScalar($propertySchema, $rawValue, $basePath);

                break;

            case DTO\Type\ObjectTypeInterface::class:
                $propertyModel = new $propertySchema['class'];
                $value = $this->mapObject($propertySchema, $propertyModel, $rawValue, $basePath);

                break;

            case DTO\Type\CollectionTypeInterface::class:
                $value = $this->mapCollection($propertySchema, $rawValue, $basePath);

                break;

            default:
                throw new \InvalidArgumentException();

        }

        return $value;
    }

    /**
     * @param array $propertySchema
     * @param mixed $rawValue
     * @param array $basePath
     *
     * @return mixed
     */
    private function mapScalar(array $propertySchema, $rawValue, array $basePath)
    {
        if (!is_scalar($rawValue)) {
            throw new Exception\MappingValidation\ScalarRequiredException($basePath);
        }

        return $rawValue;
    }

    /**
     * @param array $propertySchema
     * @param mixed $rawValue
     * @param array $basePath
     *
     * @return array
     * @throws Exception\MappingValidation\CollectionRequiredException
     */
    private function mapCollection(array $propertySchema, $rawValue, array $basePath): array
    {
        if (!is_array($rawValue) || !$this->isPlainArray($rawValue)) {
            throw new Exception\MappingValidation\CollectionRequiredException($basePath);
        }

        $value = [];

        foreach ($rawValue as $i => $item) {
            $path = $basePath;
            $path[] = $i;

            $value[] = $this->mapType($propertySchema['items'], $item, $path);
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
