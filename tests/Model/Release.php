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
     * @var \DateTime|null
     *
     * @Mapper\DateType()
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
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     *
     * @return $this
     */
    public function setDate(?\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }
}
