# Usage

Create a model implementing `Mapper\ModelInterface`.

```php
<?php

namespace Model;

use Mapper\Annotation as Mapper;
use Mapper\ModelInterface;

class Movie implements ModelInterface
{
    /**
     * @var string|null
     *
     * @Mapper\StringType(nullable=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @Mapper\BooleanType()
     */
    private $isOnlineWatchAvailable;

    /**
     * @var string[]
     *
     * @Mapper\CollectionType(type=@Mapper\StringType())
     */
    private $genres;

    /**
     * @var Release[]
     *
     * @Mapper\CollectionType(type=@Mapper\ObjectType(class="Tests\Model\Release"))
     */
    private $releases;

    ... getters and setters
}

```

Put annotation with type into docblock.

Use mapper instance by calling map() with model instance and array with data.

```php
<?php

$mapperSettings = new Mapper\DTO\Settings();
$mapperSettings
    ->setIsPropertiesNullableByDefault(false)
    ->setIsAllowedUndefinedKeysInData(false)
    ->setIsClearMissing(false);

$mapper = new Mapper\Mapper($mapperSettings);

$model = new Model\Movie();
$data = [
        'name' => 'Taxi 2',
        'isOnlineWatchAvailable' => true,
        'genres' => ['Action', 'Comedy', 'Crime',],
        'releases' => [
            [
                'country' => 'France',
                'date' => '2000-03-25'
            ]
        ]
    ];

$mapper->map($model, $data);
```

Now $models contains data from $data. 

Function ->map() can throw exceptions, in case data is invalid. List of exceptions can be found at [`exceptions.md`](exceptions.md)
