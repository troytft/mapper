<?php

namespace Tests\Model;

use RequestModelBundle\Annotation as Map;
use RequestModelBundle\RequestModelInterface;

class Locations implements RequestModelInterface
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
