<?php

namespace Tests\Model;

use RequestModelBundle\Annotation as Mapper;
use RequestModelBundle\RequestModelInterface;

class Location implements RequestModelInterface
{
    /**
     * @var string
     *
     * @Mapper\StringType()
     */
    private $latitude;

    /**
     * @var string
     *
     * @Mapper\StringType()
     */
    private $longitude;

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     *
     * @return $this
     */
    public function setLatitude(string $latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     *
     * @return $this
     */
    public function setLongitude(string $longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }
}
