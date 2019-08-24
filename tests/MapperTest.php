<?php

namespace Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Mapper;
use PHPUnit\Framework\TestCase;
use Tests\Model\Release;

class MapperTest extends TestCase
{
    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    public function __construct()
    {
        parent::__construct();

        $this->annotationReader = new AnnotationReader();
    }

    public function testFullFilled()
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
            ->setDefaultIsNullable(true)
            ->setIsUndefinedKeysInDataAllowed(false);

        $mapper = new Mapper\Mapper($mapperSettings, $this->annotationReader);
        $mapper
            ->map($model, $data);

        $this->assertEquals($model->getName(), $data['name']);
        $this->assertEquals($model->getGenres(), $data['genres']);
        $this->assertIsArray($model->getReleases());
        $this->assertArrayHasKey(0, $model->getReleases());
        $this->assertInstanceOf(Release::class, $model->getReleases()[0]);
        $this->assertEquals($model->getReleases()[0]->getCountry(), $data['releases'][0]['country']);
        $this->assertEquals($model->getReleases()[0]->getDate(), $data['releases'][0]['date']);
    }
}
