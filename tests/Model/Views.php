<?php

namespace Tests\Model;

use Mapper\Annotation as Mapper;

class Views
{
    /**
     * @var int|null
     *
     * @Mapper\IntegerType()
     */
    private $rus;

    /**
     * @var int|null
     *
     * @Mapper\IntegerType()
     */
    private $usa;

    /**
     * @return int|null
     */
    public function getRus(): ?int
    {
        return $this->rus;
    }

    /**
     * @param int|null $rus
     *
     * @return $this
     */
    public function setRus(?int $rus)
    {
        $this->rus = $rus;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUsa(): ?int
    {
        return $this->usa;
    }

    /**
     * @param int|null $usa
     *
     * @return $this
     */
    public function setUsa(?int $usa)
    {
        $this->usa = $usa;

        return $this;
    }
}
