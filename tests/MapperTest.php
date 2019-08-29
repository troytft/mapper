<?php

namespace Tests;

use Mapper;
use PHPUnit\Framework\TestCase;
use function var_dump;

class MapperTest extends TestCase
{
    private const EXCEPTION_WOS_NOT_RAISED_MESSAGE = 'Exception was not raised';

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
                    'date' => '25 March 2000'
                ],
            ],
        ];

        $mapperSettings = new Mapper\DTO\Settings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(true)
            ->setIsAllowedUndefinedKeysInData(false);

        $mapper = new Mapper\Mapper($mapperSettings, $this->getDefaultTransformers());

        $mapper->map($model, $data);

        $this->assertSame($model->getName(), $data['name']);
        $this->assertSame($model->getGenres(), $data['genres']);
        $this->assertIsArray($model->getReleases());
        $this->assertArrayHasKey(0, $model->getReleases());
        $this->assertInstanceOf(Model\Release::class, $model->getReleases()[0]);
        $this->assertSame($model->getReleases()[0]->getCountry(), $data['releases'][0]['country']);
        $this->assertSame($model->getReleases()[0]->getDate(), $data['releases'][0]['date']);
        $this->assertSame($model->getRating(), $data['rating']);
        $this->assertSame($model->getLengthMinutes(), $data['lengthMinutes']);
        $this->assertSame($model->getIsOnlineWatchAvailable(), $data['isOnlineWatchAvailable']);
    }

    public function testErrorPath()
    {
        $mapperSettings = new Mapper\DTO\Settings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(false)
            ->setIsAllowedUndefinedKeysInData(false);

        $mapper = new Mapper\Mapper($mapperSettings, $this->getDefaultTransformers());

        // object root property
        $model = new Model\Movie();
        $data = [
            'name' => '',
            'genres' => null,
            'releases' => [],
        ];

        try {
            $mapper->map($model, $data);
            $this->fail(static::EXCEPTION_WOS_NOT_RAISED_MESSAGE);
        } catch (Mapper\Exception\MappingValidation\CollectionRequiredException $exception) {
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
            $this->fail(static::EXCEPTION_WOS_NOT_RAISED_MESSAGE);
        } catch (Mapper\Exception\MappingValidation\ObjectRequiredException $exception) {
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
            $this->fail(static::EXCEPTION_WOS_NOT_RAISED_MESSAGE);
        } catch (Mapper\Exception\MappingValidation\ScalarRequiredException $exception) {
            $this->assertSame('releases.0.country', $exception->getPathAsString());
        }
    }

    public function testNotNullablePropertyNotPresentedInData()
    {
        $mapperSettings = new Mapper\DTO\Settings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(true)
            ->setIsAllowedUndefinedKeysInData(false);

        $mapper = new Mapper\Mapper($mapperSettings, $this->getDefaultTransformers());

        // nullable
        $model = new Model\Movie();
        $data = [
            'genres' => [],
            'releases' => [],
        ];

        $mapper->map($model, $data);
        $this->assertSame(null, $model->getName());

        // not nullable
        $mapperSettings->setIsPropertiesNullableByDefault(false);

        try {
            $mapper->map($model, $data);
            $this->fail(static::EXCEPTION_WOS_NOT_RAISED_MESSAGE);
        } catch (Mapper\Exception\MappingValidation\ScalarRequiredException $exception) {
            $this->assertSame('name', $exception->getPathAsString());
        }
    }

    public function testUndefinedKey()
    {
        $mapperSettings = new Mapper\DTO\Settings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(true)
            ->setIsAllowedUndefinedKeysInData(true);

        $mapper = new Mapper\Mapper($mapperSettings, $this->getDefaultTransformers());

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
            $this->fail(static::EXCEPTION_WOS_NOT_RAISED_MESSAGE);
        } catch (Mapper\Exception\MappingValidation\UndefinedKeyException $exception) {
            $this->assertSame('releases.0.name', $exception->getPathAsString());
        }
    }

    /**
     * @return array
     */
    private function getDefaultTransformers(): array
    {
        return [
            new Mapper\Transformer\StringTransformer(),
            new Mapper\Transformer\FloatTransformer(),
            new Mapper\Transformer\IntegerTransformer(),
            new Mapper\Transformer\BooleanTransformer(),
        ];
    }
}
