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
     * @var string[]|null
     *
     * @Mapper\CollectionType(type=@Mapper\StringType())
     */
    private $genres;

    /**
     * @var Release[]|null
     *
     * @Mapper\CollectionType(type=@Mapper\ObjectType(class="Tests\Model\Release"))
     */
    private $releases;

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
     * @return string[]|null
     */
    public function getGenres(): ?array
    {
        return $this->genres;
    }

    /**
     * @param string[]|null $genres
     *
     * @return $this
     */
    public function setGenres(?array $genres)
    {
        $this->genres = $genres;

        return $this;
    }

    /**
     * @return Release[]|null
     */
    public function getReleases(): ?array
    {
        return $this->releases;
    }

    /**
     * @param Release[]|null $releases
     *
     * @return $this
     */
    public function setReleases(?array $releases)
    {
        $this->releases = $releases;

        return $this;
    }
}
