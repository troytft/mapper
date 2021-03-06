<?php

namespace Tests;

use Mapper;
use PHPUnit\Framework\TestCase;

class MapperTest extends TestCase
{
    public function testSuccessFilledModel()
    {
        $model = new Model\Movie();
        $data = [
            'name' => 'Taxi 2',
            'rating' => 6.5,
            'lengthMinutes' => 88,
            'isOnlineWatchAvailable' => true,
            'genres' => ['Action', 'Comedy', 'Crime',],
            'releases' => [
                [
                    'country' => 'France',
                    'date' => '2000-03-25'
                ],
            ],
        ];

        $mapperSettings = new Mapper\DTO\Settings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(true)
            ->setIsAllowedUndefinedKeysInData(false);

        $mapper = new Mapper\Mapper($mapperSettings);

        $mapper->map($model, $data);

        $this->assertSame($model->name, $data['name']);
        $this->assertSame($model->getGenres(), $data['genres']);
        $this->assertIsArray($model->getReleases());
        $this->assertArrayHasKey(0, $model->getReleases());
        $this->assertInstanceOf(Model\Release::class, $model->getReleases()[0]);
        $this->assertSame($model->getReleases()[0]->getCountry(), $data['releases'][0]['country']);
        $this->assertSame($model->getReleases()[0]->getDate()->format('Y-m-d'), $data['releases'][0]['date']);
        $this->assertSame($model->rating, $data['rating']);
        $this->assertSame($model->getLengthMinutes(), $data['lengthMinutes']);
        $this->assertSame($model->getIsOnlineWatchAvailable(), $data['isOnlineWatchAvailable']);
    }

    public function testClearMissingEnabled()
    {
        $settings = new Mapper\DTO\Settings();
        $settings
            ->setIsClearMissing(true);

        $mapper = new Mapper\Mapper($settings);
        try {
            $mapper->map(new Model\Movie(), []);
            $this->fail();
        } catch (Mapper\Exception\MappingValidation\CanNotBeNullException $exception) {
            $this->assertSame('name', $exception->getPathAsString());
        }
    }

    public function testClearMissingDisabled()
    {
        $settings = new Mapper\DTO\Settings();
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
        $mapper = new Mapper\Mapper();

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
        } catch (Mapper\Exception\MappingValidation\CanNotBeNullException $exception) {
            $this->assertSame('genres', $exception->getPathAsString());
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
        } catch (Mapper\Exception\MappingValidation\CanNotBeNullException $exception) {
            $this->assertSame('releases.0', $exception->getPathAsString());
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
        } catch (Mapper\Exception\MappingValidation\CanNotBeNullException $exception) {
            $this->assertSame('releases.0.country', $exception->getPathAsString());
        }
    }

    public function testNullablePropertyNotPresentedInData()
    {
        $mapperSettings = new Mapper\DTO\Settings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(true)
            ->setIsAllowedUndefinedKeysInData(false);

        $mapper = new Mapper\Mapper($mapperSettings);

        // nullable
        $model = new Model\Movie();
        $data = [
            'name' => null,
            'genres' => null,
            'releases' => null,
        ];

        $mapper->map($model, $data);
        $this->assertSame(null, $model->name);
    }

    public function testNotNullablePropertyNotPresentedInData()
    {
        $mapperSettings = new Mapper\DTO\Settings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(true)
            ->setIsAllowedUndefinedKeysInData(false);

        $mapper = new Mapper\Mapper($mapperSettings);

        // nullable
        $model = new Model\Movie();
        $data = [
            'name' => null,
            'genres' => null,
            'releases' => null,
        ];

        // not nullable
        $mapperSettings->setIsPropertiesNullableByDefault(false);
        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\MappingValidation\CanNotBeNullException $exception) {
            $this->assertSame('name', $exception->getPathAsString());
        }
    }

    public function testUndefinedKey()
    {
        $mapperSettings = new Mapper\DTO\Settings();
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
        } catch (Mapper\Exception\MappingValidation\UndefinedKeyException $exception) {
            $this->assertSame('releases.0.name', $exception->getPathAsString());
        }
    }

    public function testStringTransformerInvalidDataType()
    {
        $mapper = new Mapper\Mapper();

        $model = new Model\Movie();
        $data = [
            'name' => 10,
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\Transformer\WrappedTransformerException $exception) {
            $this->assertSame('name', $exception->getPathAsString());
        }
    }

    public function testFloatTransformerInvalidDataType()
    {
        $mapper = new Mapper\Mapper();

        $model = new Model\Movie();
        $data = [
            'rating' => 'ss',
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\Transformer\WrappedTransformerException $exception) {
            $this->assertSame('rating', $exception->getPathAsString());
        }
    }

    public function testIntegerTransformerInvalidDataType()
    {
        $mapper = new Mapper\Mapper();

        $model = new Model\Movie();
        $data = [
            'lengthMinutes' => 'ss',
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\Transformer\WrappedTransformerException $exception) {
            $this->assertSame('lengthMinutes', $exception->getPathAsString());
        }
    }

    public function testBooleanTransformerInvalidDataType()
    {
        $mapper = new Mapper\Mapper();

        $model = new Model\Movie();
        $data = [
            'isOnlineWatchAvailable' => 'ss',
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\Transformer\WrappedTransformerException $exception) {
            $this->assertSame('isOnlineWatchAvailable', $exception->getPathAsString());
        }
    }

    public function testDateTimeTransformerInvalidDataType()
    {
        $mapper = new Mapper\Mapper();

        $model = new Model\Movie();
        $data = [
            'isOnlineWatchAvailable' => 'ss',
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\Transformer\WrappedTransformerException $exception) {
            $this->assertSame('isOnlineWatchAvailable', $exception->getPathAsString());
        }
    }

    public function testDateTransformerInvalidDataType()
    {
        $mapperSettings = new Mapper\DTO\Settings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(true)
            ->setIsAllowedUndefinedKeysInData(false);

        $mapper = new Mapper\Mapper($mapperSettings);

        $model = new Model\Release();
        $data = [
            'date' => 'invalid date',
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\Transformer\WrappedTransformerException $exception) {
            $this->assertSame('date', $exception->getPathAsString());
            $this->assertInstanceOf(Mapper\Exception\Transformer\InvalidDateFormatException::class, $exception->getPrevious());
        }
    }

    public function testTimestampTransformerInvalidDataType()
    {
        $mapper = new Mapper\Mapper();

        $model = new Model\Movie();
        $data = [
            'isOnlineWatchAvailable' => 'ss',
        ];

        try {
            $mapper->map($model, $data);
            $this->fail();
        } catch (Mapper\Exception\Transformer\WrappedTransformerException $exception) {
            $this->assertSame('isOnlineWatchAvailable', $exception->getPathAsString());
        }
    }
}
