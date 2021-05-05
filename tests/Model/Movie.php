<?php

namespace Tests\Model;

use Mapper\Annotation as Mapper;
use Mapper\ModelInterface;

class Movie implements ModelInterface
{
    /**
     * @Mapper\StringType()
     */
    public ?string $name;

    /**
     * @Mapper\FloatType()
     */
    public ?float $rating;

    /**
     * @var int|null
     *
     * @Mapper\IntegerType()
     */
    private $lengthMinutes;

    /**
     * @var bool|null
     *
     * @Mapper\BooleanType()
     */
    private $isOnlineWatchAvailable;

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

    /**
     * @return int|null
     */
    public function getLengthMinutes(): ?int
    {
        return $this->lengthMinutes;
    }

    /**
     * @param int|null $lengthMinutes
     *
     * @return $this
     */
    public function setLengthMinutes(?int $lengthMinutes)
    {
        $this->lengthMinutes = $lengthMinutes;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsOnlineWatchAvailable(): ?bool
    {
        return $this->isOnlineWatchAvailable;
    }

    /**
     * @param bool|null $isOnlineWatchAvailable
     *
     * @return $this
     */
    public function setIsOnlineWatchAvailable(?bool $isOnlineWatchAvailable)
    {
        $this->isOnlineWatchAvailable = $isOnlineWatchAvailable;

        return $this;
    }
}
