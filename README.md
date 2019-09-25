# Mapper

[![Build Status](https://travis-ci.org/troytft/mapper.svg?branch=master)](https://travis-ci.org/troytft/mapper)

Mapper is a PHP library for mapping data to objects. 

Features:
* Supports scalar types: integer, float, boolean, string
* Supports any nesting level using object and collection types
* Supports work with dates
* Allows write your own types

[`Full doumentation`](docs/main.md)

### Installation

```bash
composer require troytft/mapper
```

### Usage
```php
<?php

use Mapper\Annotation as Mapper;
use Mapper\ModelInterface;

class Movie implements ModelInterface
{
    /**
     * @var string
     *
     * @Mapper\StringType()
     */
    private $name;

    /**
     * @var Release[]|null
     *
     * @Mapper\CollectionType(type=@Mapper\ObjectType(class="Model\Release"), nullable=true)
     */
    private $releases;
    
    ... getters and setters
}

$model = new Movie();
$data = [
    'name' => 'Taxi 2',
    'releases' => [
        [
            'country' => 'France',
            'date' => '2000-03-25'
        ],
    ]
];

$mapper->map($model, $data);
```
