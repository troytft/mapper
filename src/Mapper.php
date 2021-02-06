<?php

namespace Mapper;

use Mapper\DTO\Settings;
use Mapper\Exception\MappingValidation\MappingValidationExceptionInterface;
use Mapper\Exception\StackableMappingExceptionInterface;
use Mapper\Exception\StackedMappingException;
use Mapper\Exception\Transformer\TransformerExceptionInterface;
use Mapper\Exception\Transformer\WrappedTransformerException;
use Mapper\Transformer\TransformerInterface;

use function array_diff;
use function array_is_list;
use function array_keys;
use function array_map;
use function array_merge;
use function count;
use function get_class;
use function is_array;
use function call_user_func;
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
    private $transformers = [];

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

    public function getSettings(): DTO\Settings
    {
        return $this->settings;
    }

    public function setSettings(DTO\Settings $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    public function map(ModelInterface $model, array $data)
    {
        $schema = $this->schemaGenerator->generate($model);
        $this->mapObject($schema, $model, $data, []);
    }

    private function mapObject(DTO\Schema\ObjectTypeInterface $schema, ModelInterface $model, $rawValue, array $basePath): ModelInterface
    {
        $exceptionsStack = [];

        foreach ($rawValue as $propertyName => $propertyValue) {
            try {
                if (!isset($schema->getProperties()[$propertyName])) {
                    if ($this->settings->getIsAllowedUndefinedKeysInData()) {
                        continue;
                    } else {
                        throw new Exception\MappingValidation\UndefinedKeyException($this->resolvePath($basePath, $propertyName));
                    }
                }

                $propertySchema = $schema->getProperties()[$propertyName];
                $this->setPropertyToModel($model, $propertyName, $propertySchema, $propertyValue, $basePath);
            } catch (StackableMappingExceptionInterface $exception) {
                if (!$this->settings->getStackMappingExceptions()) {
                    throw $exception;
                }

                $exceptionsStack[] = $exception;
            } catch (StackedMappingException $exception) {
                $exceptionsStack = array_merge($exceptionsStack, $exception->getExceptions());
            }
        }

        $propertiesNotPresentedInBody = array_diff(array_keys($schema->getProperties()), array_keys($rawValue));

        foreach ($propertiesNotPresentedInBody as $propertyName) {
            try {
                $propertySchema = $schema->getProperties()[$propertyName];
                if ($propertySchema->getNullable() || !$this->settings->getIsClearMissing()) {
                    continue;
                }

                $this->setPropertyToModel($model, $propertyName, $propertySchema, null, $basePath);
            } catch (StackableMappingExceptionInterface $exception) {
                if (!$this->settings->getStackMappingExceptions()) {
                    throw $exception;
                }

                $exceptionsStack[] = $exception;
            } catch (StackedMappingException $exception) {
                $exceptionsStack = array_merge($exceptionsStack, $exception->getExceptions());
            }
        }

        if ($exceptionsStack) {
            throw new StackedMappingException($exceptionsStack);
        }

        return $model;
    }

    private function setPropertyToModel(ModelInterface $model, string $propertyName, DTO\Schema\TypeInterface $schema, $rawValue, array $basePath)
    {
        $value = $this->mapType($schema, $rawValue, $this->resolvePath($basePath, $propertyName));

        $setterName = 'set' . ucfirst($propertyName);
        if (!method_exists($model, $setterName)) {
            throw new Exception\SetterDoesNotExistException($setterName);
        }

        call_user_func([$model, $setterName], $value);
    }

    private function mapType(DTO\Schema\TypeInterface $schema, $rawValue, array $basePath)
    {
        if ($rawValue === null && $schema->getNullable()) {
            return null;
        } elseif ($rawValue === null && !$schema->getNullable()) {
            throw new Exception\MappingValidation\CanNotBeNullException($basePath);
        }

        switch (true) {
            case $schema instanceof DTO\Schema\ScalarTypeInterface:
                $value = $this->mapScalarType($schema, $rawValue, $basePath);

                break;

            case $schema instanceof DTO\Schema\ObjectTypeInterface:
                $class = $schema->getClassName();
                if (!is_array($rawValue) || (count($rawValue) > 0 && array_is_list($rawValue))) {
                    throw new Exception\MappingValidation\ObjectRequiredException($basePath);
                }
                $value = $this->mapObject($schema, new $class(), $rawValue, $basePath);

                break;

            case $schema instanceof DTO\Schema\CollectionTypeInterface:
                $value = $this->mapCollectionType($schema, $rawValue, $basePath);

                break;

            default:
                throw new \InvalidArgumentException();

        }

        if ($schema->getTransformerName()) {
            try {
                $value = $this->transformers[$schema->getTransformerName()]->transform($value, $schema->getTransformerOptions());
            } catch (TransformerExceptionInterface $transformerException) {
                throw new WrappedTransformerException($transformerException, $basePath);
            }
        }

        return $value;
    }

    private function mapScalarType(DTO\Schema\ScalarTypeInterface $schema, $rawValue, array $basePath)
    {
        return $rawValue;
    }

    private function mapCollectionType(DTO\Schema\CollectionTypeInterface $schema, $rawValue, array $basePath): array
    {
        if (!is_array($rawValue) || !array_is_list($rawValue)) {
            throw new Exception\MappingValidation\CollectionRequiredException($basePath);
        }

        $value = [];

        foreach ($rawValue as $i => $item) {
            $value[] = $this->mapType($schema->getItems(), $item, $this->resolvePath($basePath, $i));
        }

        return $value;
    }

    private function resolvePath(array $basePath, $newNode): array
    {
        $path = $basePath;
        $path[] = $newNode;

        return $path;
    }

    public function addTransformer(TransformerInterface $transformer)
    {
        $this->transformers[$transformer::getName()] = $transformer;

        return $this;
    }

    public function getSchemaGenerator(): SchemaGenerator
    {
        return $this->schemaGenerator;
    }
}
