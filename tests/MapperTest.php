<?php

namespace Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Mapper;
use PHPUnit\Framework\TestCase;
use Tests\Model\Movie;
use Tests\Model\Release;
use function var_dump;

class MapperTest extends TestCase
{
    private const EXCEPTION_WOS_NOT_RAISED_MESSAGE = 'Exception was not raised';

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    public function __construct()
    {
        parent::__construct();

        $this->annotationReader = new AnnotationReader();
    }

    public function testSuccessFilledModel()
    {
        $model = new Model\Movie();
        $data = [
            'name' => 'Taxi 2',
            'genres' => ['Action', 'Comedy', 'Crime',],
            'releases' => [
                [
                    'country' => 'France',
                    'date' => '25 March 2000'
                ],
            ],
        ];

        $mapperSettings = new Mapper\DTO\MapperSettings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(true)
            ->setIsUndefinedKeysInDataAllowed(false);

        $mapper = new Mapper\Mapper($mapperSettings, $this->annotationReader);
        $mapper
            ->map($model, $data);

        $this->assertSame($model->getName(), $data['name']);
        $this->assertSame($model->getGenres(), $data['genres']);
        $this->assertIsArray($model->getReleases());
        $this->assertArrayHasKey(0, $model->getReleases());
        $this->assertInstanceOf(Release::class, $model->getReleases()[0]);
        $this->assertSame($model->getReleases()[0]->getCountry(), $data['releases'][0]['country']);
        $this->assertSame($model->getReleases()[0]->getDate(), $data['releases'][0]['date']);
    }

    public function testErrorPath()
    {
        $mapperSettings = new Mapper\DTO\MapperSettings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(false)
            ->setIsUndefinedKeysInDataAllowed(false);

        $mapper = new Mapper\Mapper($mapperSettings, $this->annotationReader);

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
        } catch (Mapper\Exception\CollectionRequiredValidationException $exception) {
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
        } catch (Mapper\Exception\ObjectRequiredValidationException $exception) {
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
        } catch (Mapper\Exception\ScalarRequiredValidationException $exception) {
            $this->assertSame('releases.0.country', $exception->getPathAsString());
        }
    }

    public function testNotNullablePropertyNotPresentedInData()
    {
        $mapperSettings = new Mapper\DTO\MapperSettings();
        $mapperSettings
            ->setIsPropertiesNullableByDefault(true)
            ->setIsUndefinedKeysInDataAllowed(false);

        $mapper = new Mapper\Mapper($mapperSettings, $this->annotationReader);

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
        } catch (Mapper\Exception\ScalarRequiredValidationException $exception) {
            $this->assertSame('name', $exception->getPathAsString());
        }
    }
}
