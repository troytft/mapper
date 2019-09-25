<?php

namespace Mapper;

use Mapper\DTO\Settings;
use function array_diff;
use function array_keys;
use function count;
use function get_class;
use function is_array;
use function is_scalar;
use function call_user_func;
use Mapper\Exception\Transformer\TransformerExceptionInterface;
use Mapper\Exception\Transformer\WrappedTransformerException;
use Mapper\Transformer\TransformerInterface;
use function method_exists;
use function sprintf;
use function ucfirst;
use function var_dump;

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
     * @var TransformerInterface[]
     */
    private $transformersByClass = [];

    /**
     * @param DTO\Settings $settings
     * @param Transformer\TransformerInterface[] $transformers
     */
    public function __construct(?DTO\Settings $settings = null)
    {
        $this->settings = $settings ?: new Settings();
        $this->schemaGenerator = new SchemaGenerator($this->settings);

        $this
            ->addTransformer(new Transformer\StringTransformer())
            ->addTransformer(new Transformer\FloatTransformer())
            ->addTransformer(new Transformer\IntegerTransformer())
            ->addTransformer(new Transformer\BooleanTransformer())
            ->addTransformer(new Transformer\DateTimeTransformer())
            ->addTransformer(new Transformer\DateTransformer())
            ->addTransformer(new Transformer\TimestampTransformer());
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
     * @throws Exception\ExceptionInterface
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
        if (!is_array($rawValue) || (count($rawValue) > 0 && $this->isPlainArray($rawValue))) {
            throw new Exception\MappingValidation\ObjectRequiredException($basePath);
        }

        foreach ($rawValue as $propertyName => $propertyValue) {
            if (!isset($schema->getProperties()[$propertyName])) {
                if ($this->settings->getIsAllowedUndefinedKeysInData()) {
                    continue;
                } else {
                    throw new Exception\MappingValidation\UndefinedKeyException($this->resolvePath($basePath, $propertyName));
                }
            }

            $propertySchema = $schema->getProperties()[$propertyName];
            $this->setPropertyToModel($model, $propertyName, $propertySchema, $propertyValue, $basePath);
        }

        $propertiesNotPresentedInBody = array_diff(array_keys($schema->getProperties()), array_keys($rawValue));

        foreach ($propertiesNotPresentedInBody as $propertyName) {
            $propertySchema = $schema->getProperties()[$propertyName];
            if ($propertySchema->getNullable() || !$this->settings->getIsClearMissing()) {
                continue;
            }

            $this->setPropertyToModel($model, $propertyName, $propertySchema, null, $basePath);
        }

        return $model;
    }

    /**
     * @param ModelInterface $model
     * @param string $propertyName
     * @param DTO\Schema\TypeInterface $schema
     * @param $rawValue
     *
     * @throws Exception\SetterDoesNotExistException
     */
    private function setPropertyToModel(ModelInterface $model, string $propertyName, DTO\Schema\TypeInterface $schema, $rawValue, array $basePath)
    {
        $value = $this->mapType($schema, $rawValue, $this->resolvePath($basePath, $propertyName));

        $setterName = 'set' . ucfirst($propertyName);
        if (!method_exists($model, $setterName)) {
            throw new Exception\SetterDoesNotExistException($setterName);
        }

        call_user_func([$model, $setterName], $value);
    }

    /**
     * @param DTO\Schema\TypeInterface $schema
     * @param mixed|null $rawValue
     * @param array $basePath
     * @return mixed|null
     */
    private function mapType(DTO\Schema\TypeInterface $schema, $rawValue, array $basePath)
    {
        if ($schema->getNullable() && $rawValue === null) {
            return null;
        }

        switch (true) {
            case $schema instanceof DTO\Schema\ScalarTypeInterface:
                $value = $this->mapScalarType($schema, $rawValue, $basePath);

                break;

            case $schema instanceof DTO\Schema\ObjectTypeInterface:
                $class = $schema->getClass();
                $value = $this->mapObject($schema, new $class(), $rawValue, $basePath);

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

        if (!isset($this->transformersByClass[$schema->getTransformer()])) {
            throw new Exception\UndefinedTransformerException(sprintf('Can not find transformer with name "%s"', $schema->getTransformer()));
        }

        try {
            $value = $this->transformersByClass[$schema->getTransformer()]->transform($rawValue, $schema->getTransformerOptions());
        } catch (TransformerExceptionInterface $transformerException) {
            throw new WrappedTransformerException($transformerException, $basePath);
        }

        return $value;
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
            $value[] = $this->mapType($schema->getItems(), $item, $this->resolvePath($basePath, $i));
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

    /**
     * @param array $basePath
     * @param $newNode
     *
     * @return array
     */
    private function resolvePath(array $basePath, $newNode): array
    {
        $path = $basePath;
        $path[] = $newNode;

        return $path;
    }

    /**
     * @param TransformerInterface $transformer
     *
     * @return $this
     */
    public function addTransformer(TransformerInterface $transformer)
    {
        $this->transformersByClass[get_class($transformer)] = $transformer;

        return $this;
    }
}
