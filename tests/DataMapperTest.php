<?php

namespace Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use RequestModelBundle;
use PHPUnit\Framework\TestCase;
use function var_dump;

class DataMapperTest extends TestCase
{
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
        } catch (RequestModelBundle\Exception\AbstractMappingException $exception) {
            var_dump($exception->getPathAsString());
            die();
        }
    }

    /**
     * @return RequestModelBundle\DataMapper
     */
    private function prepareDataMapper(): RequestModelBundle\DataMapper
    {
        $annotationReader = new AnnotationReader();

        $dataMapper = new RequestModelBundle\DataMapper($annotationReader);


        return $dataMapper;
    }
}
