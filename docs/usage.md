# Usage

Создайте модель, наследующую интерфейс `Mapper\ModelInterface`.

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
     * @Mapper\StringType()
     */
    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }
}

```

В док блоке у свойств класса можно указать аннатоцию с одним из типов.

Далее наобходимо использовать маппер и передать в него модель и массив с данными:

```php
<?php

$mapperSettings = new Mapper\DTO\Settings();
$mapperSettings
    ->setIsPropertiesNullableByDefault(false)
    ->setIsAllowedUndefinedKeysInData(false)
    ->setIsCLearMissing(false);

$mapper = new Mapper\Mapper($mapperSettings);

$model = new Model\Movie();
$data = [
    'name' => 'Taxi 2',
	'rating' => 6.5
];

$mapper->map($model, $data);

```

После выполнения – данные будут применены на модель, в случае ошибки будет выбрашено одно из исключений.
