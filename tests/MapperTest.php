<?php

namespace Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Mapper;
use PHPUnit\Framework\TestCase;

class MapperTest extends TestCase
{
    /**
     * @var Mapper\Mapper
     */
    private $mapper;

    public function __construct()
    {
        parent::__construct();

        $this->initMapper();
    }

    private function initMapper(): void
    {
        $annotationReader = new AnnotationReader();
        $this->mapper = new Mapper\Mapper($annotationReader);
    }
//    public function testSuccessString()
//    {
//        $model = new Model\User();
//        $data = [
//            'name' => 'Name',
//            'surname' => 'Surname',
//        ];
//
//        $annotationReader = new AnnotationReader();
//
//        $dataMapper = new RequestModelBundle\DataMapper($annotationReader);
//        $dataMapper
//            ->addTransformer(new RequestModelBundle\Transformer\StringTransformer());
//
//        $resultContext = $dataMapper->map($model, $data);
//
//        $this->assertTrue($resultContext instanceof RequestModelBundle\ResultContext);
//        $this->assertEquals($model->getName(), 'Name');
//        $this->assertEquals($model->getSurname(), 'Surname');
//    }

    public function testWrongType()
    {
        $model = new Model\User();
        $data = [
            'name' => 'surname',
            'surname' => 'Surname',
            'city' => [
                'latitude' => 50.33,
                'longitude' => 30.222,
            ],
            'workPlaces' => [
                [
                    'latitude' => 50.33,
                    'longitude' => null,
                ]
            ],
            'dd' => 'ss',
        ];

        try {
            $this->prepareDataMapper()->map($model, $data);
        } catch (Mapper\Exception\AbstractMappingValidationException $exception) {
            var_dump($exception->getPathAsString());
            die();
        }
    }

    /**
     * @return Mapper\Mapper
     */
    private function prepareDataMapper(): Mapper\Mapper
    {
        $annotationReader = new AnnotationReader();

        $dataMapper = new Mapper\Mapper($annotationReader);


        return $dataMapper;
    }
}
