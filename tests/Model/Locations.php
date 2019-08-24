<?php

namespace Tests\Model;

use Mapper\Annotation as Map;
use Mapper\ModelInterface;

class Locations implements ModelInterface
{
    /**
     * @var array
     *
     * @Map\Collection(type=@Map\ObjectType(class="Tests\Model\Location"))
     */
    private $items = [];

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     *
     * @return $this
     */
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }
}
