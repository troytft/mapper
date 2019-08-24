<?php

namespace Tests\Model;

use Mapper\Annotation as Mapper;
use Mapper\ModelInterface;

class Release implements ModelInterface
{
    /**
     * @var string|null
     *
     * @Mapper\StringType()
     */
    private $country;

    /**
     * @var string|null
     *
     * @Mapper\StringType()
     */
    private $date;

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     *
     * @return $this
     */
    public function setCountry(?string $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     *
     * @return $this
     */
    public function setDate(?string $date)
    {
        $this->date = $date;

        return $this;
    }
}
