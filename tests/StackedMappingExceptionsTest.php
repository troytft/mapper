<?php

namespace Tests;

use Mapper;
use PHPUnit\Framework\TestCase;

class StackedMappingExceptionsTest extends TestCase
{
    private function getDefaultSettings(): Mapper\DTO\Settings
    {
        $settings = new Mapper\DTO\Settings();
        $settings
            ->setStackMappingExceptions(true);

        return $settings;
    }

    public function testClearMissingEnabled()
    {
        $settings = $this->getDefaultSettings();
        $settings
            ->setIsClearMissing(true);

        $mapper = new Mapper\Mapper($settings);
        try {
            $mapper->map(new Model\Movie(), []);
            $this->fail();
        } catch (Mapper\Exception\StackedMappingException $exception) {
            $this->assertCount(6, $exception->getExceptions());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[0]);
            $this->assertSame('name', $exception->getExceptions()[0]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[1]);
            $this->assertSame('rating', $exception->getExceptions()[1]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[2]);
            $this->assertSame('lengthMinutes', $exception->getExceptions()[2]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[3]);
            $this->assertSame('isOnlineWatchAvailable', $exception->getExceptions()[3]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[4]);
            $this->assertSame('genres', $exception->getExceptions()[4]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[5]);
            $this->assertSame('releases', $exception->getExceptions()[5]->getPathAsString());
        }
    }

    public function testClearMissingDisabled()
    {
        $settings = $this->getDefaultSettings();
        $settings
            ->setIsClearMissing(false);

        $movie = new Model\Movie();
        $movie
            ->name = 'Taxi 2';

        $mapper = new Mapper\Mapper($settings);
        $mapper->map($movie, []);

        $this->assertSame('Taxi 2', $movie->name);
    }

    public function testErrorPath()
    {
        $settings = $this->getDefaultSettings();

        $mapper = new Mapper\Mapper($settings);

        // object root property
        $model = new Model\Movie();
        $data = [
            'name' => '',
            'genres' => null,
            'releases' => [],
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\StackedMappingException $exception) {
            $this->assertCount(4, $exception->getExceptions());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[0]);
            $this->assertSame('genres', $exception->getExceptions()[0]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[1]);
            $this->assertSame('rating', $exception->getExceptions()[1]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[2]);
            $this->assertSame('lengthMinutes', $exception->getExceptions()[2]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[3]);
            $this->assertSame('isOnlineWatchAvailable', $exception->getExceptions()[3]->getPathAsString());
        }

        // collection item
        $model = new Model\Movie();
        $data = [
            'name' => '',
            'genres' => [],
            'releases' => [
                null,
            ]
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\StackedMappingException $exception) {
            $this->assertCount(4, $exception->getExceptions());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[0]);
            $this->assertSame('releases.0', $exception->getExceptions()[0]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[1]);
            $this->assertSame('rating', $exception->getExceptions()[1]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[2]);
            $this->assertSame('lengthMinutes', $exception->getExceptions()[2]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[3]);
            $this->assertSame('isOnlineWatchAvailable', $exception->getExceptions()[3]->getPathAsString());
        }

        // object property inside collection
        $model = new Model\Movie();
        $data = [
            'name' => '',
            'genres' => [],
            'releases' => [
                [
                    'country' => null,
                    'date' => null,
                ]
            ]
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\StackedMappingException $exception) {
            $this->assertCount(5, $exception->getExceptions());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[0]);
            $this->assertSame('releases.0.country', $exception->getExceptions()[0]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[1]);
            $this->assertSame('releases.0.date', $exception->getExceptions()[1]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[2]);
            $this->assertSame('rating', $exception->getExceptions()[2]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[3]);
            $this->assertSame('lengthMinutes', $exception->getExceptions()[3]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[4]);
            $this->assertSame('isOnlineWatchAvailable', $exception->getExceptions()[4]->getPathAsString());
        }
    }

    public function testUndefinedKey()
    {
        $mapperSettings = $this->getDefaultSettings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(true)
            ->setIsAllowedUndefinedKeysInData(true);

        $mapper = new Mapper\Mapper($mapperSettings);

        $model = new Model\Movie();
        $data = [
            'releases' => [
                [
                    'name' => 'Release 1',
                ]
            ]
        ];

        // allowed
        $mapper->map($model, $data);

        // not allowed
        $mapperSettings->setIsAllowedUndefinedKeysInData(false);

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\StackedMappingException $exception) {
            $this->assertCount(1, $exception->getExceptions());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\UndefinedKeyException::class, $exception->getExceptions()[0]);
            $this->assertSame('releases.0.name', $exception->getExceptions()[0]->getPathAsString());
        }
    }

    public function testWrappedTransformer()
    {
        $settings = $this->getDefaultSettings();

        $mapper = new Mapper\Mapper($settings);

        $model = new Model\Movie();
        $data = [
            'name' => 10,
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\StackedMappingException $exception) {
            $this->assertCount(6, $exception->getExceptions());

            /** @var Mapper\Exception\Transformer\WrappedTransformerException $wrappedTransformerException */
            $wrappedTransformerException = $exception->getExceptions()[0];
            $this->assertInstanceOf(Mapper\Exception\Transformer\WrappedTransformerException::class, $wrappedTransformerException);
            $this->assertSame('name', $wrappedTransformerException->getPathAsString());
            $this->assertInstanceOf(Mapper\Exception\Transformer\StringRequiredException::class, $wrappedTransformerException->getTransformerException());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[1]);
            $this->assertSame('rating', $exception->getExceptions()[1]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[2]);
            $this->assertSame('lengthMinutes', $exception->getExceptions()[2]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[3]);
            $this->assertSame('isOnlineWatchAvailable', $exception->getExceptions()[3]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[4]);
            $this->assertSame('genres', $exception->getExceptions()[4]->getPathAsString());

            $this->assertInstanceOf(Mapper\Exception\MappingValidation\CanNotBeNullException::class, $exception->getExceptions()[5]);
            $this->assertSame('releases', $exception->getExceptions()[5]->getPathAsString());
        }
    }
}
