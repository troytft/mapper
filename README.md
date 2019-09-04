# Mapper

[![Build Status](https://travis-ci.org/troytft/mapper.svg?branch=master)](https://travis-ci.org/troytft/mapper)

Маппинг данных на модели. 

* Поддерживаются разные типы данных, в том числе объекты и коллекции, можно строить модели любого уровня вложенности
* Поддерживается трансформация сырых скалярных данных в любой другой тип, перед установкой значения в свойство. 

[`Полная докуменнтация`](docs/main.md)

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
            'date' => '25 March 2000'
        ],
    ]
];

$mapper->map($model, $data);
```