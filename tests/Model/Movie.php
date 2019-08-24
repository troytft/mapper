<?php

namespace Tests\Model;

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

    /**
     * @var Actor[]|null
     *
     * @Mapper\CollectionType(type=@Mapper\ObjectType(class="Tests\Model\Actor"))
     */
    private $actors;

    /**
     * @var Views|null
     */
    private $views;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return $this
     */
    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Actor[]|null
     */
    public function getActors(): ?array
    {
        return $this->actors;
    }

    /**
     * @param Actor[]|null $actors
     *
     * @return $this
     */
    public function setActors(?array $actors)
    {
        $this->actors = $actors;

        return $this;
    }

    /**
     * @return Views|null
     */
    public function getViews(): ?Views
    {
        return $this->views;
    }

    /**
     * @param Views|null $views
     *
     * @return $this
     */
    public function setViews(?Views $views)
    {
        $this->views = $views;

        return $this;
    }
}
