<?php

namespace Tests;

use Mapper;
use PHPUnit\Framework\TestCase;

class SchemaGeneratorTest extends TestCase
{
    public function testIsModelHasPropertyFunction()
    {
        $schemaGenerator = new Mapper\SchemaGenerator(new Mapper\DTO\Settings());
        $model = new Model\Movie();

        $this->assertTrue($schemaGenerator->isModelHasProperty($model, 'name'));
        $this->assertFalse($schemaGenerator->isModelHasProperty($model, 'surname'));
    }
}
