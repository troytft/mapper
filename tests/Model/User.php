<?php

namespace Tests\Model;

use RequestModelBundle\Annotation as Mapper;
use RequestModelBundle\RequestModelInterface;

class User implements RequestModelInterface
{
    /**
     * @var string
     *
     * @Mapper\StringType()
     */
    private $name;

    /**
     * @var string
     *
     * @Mapper\StringType()
     */
    private $surname;

    /**
     * @var Location
     *
     * @Mapper\ObjectType(class="Tests\Model\Location")
     */
    private $city;

    /**
     * @var array
     *
     * @Mapper\CollectionType(type=@Mapper\ObjectType(class="Tests\Model\Location"))
     */
    private $workPlaces;

    /**
     * @var \DateTime
     *
     * Map\DateTimeType()
     */
    //private $date;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return $this
     */
    public function setSurname(string $surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Location
     */
    public function getCity(): Location
    {
        return $this->city;
    }

    /**
     * @param Location $city
     *
     * @return $this
     */
    public function setCity(Location $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return array
     */
    public function getWorkPlaces(): array
    {
        return $this->workPlaces;
    }

    /**
     * @param array $workPlaces
     *
     * @return $this
     */
    public function setWorkPlaces(array $workPlaces)
    {
        $this->workPlaces = $workPlaces;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }
}
