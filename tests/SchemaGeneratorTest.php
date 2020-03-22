<?php

namespace Tests;

use Mapper;
use PHPUnit\Framework\TestCase;
use function var_dump;

class SchemaGeneratorTest extends TestCase
{
    public function testIsModelHasPropertyFunction()
    {
        $schemaGenerator = new Mapper\SchemaGenerator(new Mapper\DTO\Settings());
        $model = new Model\Movie();

        $this->assertTrue($schemaGenerator->isModelHasProperty($model, 'name'));
        $this->assertFalse($schemaGenerator->isModelHasProperty($model, 'surname'));
    }

    public function testGetSchemaByClassName()
    {
        $schemaGenerator = new Mapper\SchemaGenerator(new Mapper\DTO\Settings());
        $className = Model\Movie::class;

        $properties = $schemaGenerator->getSchemaByClassName($className)->getProperties();

        $this->assertCount(6, $properties);

        $this->assertArrayHasKey('name', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\ScalarType::class, $properties['name']);

        $this->assertArrayHasKey('rating', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\ScalarType::class, $properties['rating']);

        $this->assertArrayHasKey('lengthMinutes', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\ScalarType::class, $properties['lengthMinutes']);

        $this->assertArrayHasKey('isOnlineWatchAvailable', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\ScalarType::class, $properties['isOnlineWatchAvailable']);

        $this->assertArrayHasKey('genres', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\CollectionType::class, $properties['genres']);

        $this->assertArrayHasKey('releases', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\CollectionType::class, $properties['releases']);
    }

    public function testGetSchemaByClassInstance()
    {
        $schemaGenerator = new Mapper\SchemaGenerator(new Mapper\DTO\Settings());
        $classInstance = new Model\Movie();

        $properties = $schemaGenerator->getSchemaByClassInstance($classInstance)->getProperties();

        $this->assertCount(6, $properties);

        $this->assertArrayHasKey('name', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\ScalarType::class, $properties['name']);

        $this->assertArrayHasKey('rating', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\ScalarType::class, $properties['rating']);

        $this->assertArrayHasKey('lengthMinutes', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\ScalarType::class, $properties['lengthMinutes']);

        $this->assertArrayHasKey('isOnlineWatchAvailable', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\ScalarType::class, $properties['isOnlineWatchAvailable']);

        $this->assertArrayHasKey('genres', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\CollectionType::class, $properties['genres']);

        $this->assertArrayHasKey('releases', $properties);
        $this->assertInstanceOf(Mapper\DTO\Schema\CollectionType::class, $properties['releases']);
    }
}
