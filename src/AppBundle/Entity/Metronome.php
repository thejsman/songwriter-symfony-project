<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ExternalResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Embeddable
 */
class Metronome
{
    use ExternalResource;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups("default")
     */
    private $tact;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups("default")
     */
    private $firstPart;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups("default")
     */
    private $secondPart;

    /**
     * @return int|null
     */
    public function getTact(): ?int
    {
        return $this->tact;
    }

    /**
     * @param int $tact
     *
     * @return self
     */
    public function setTact(int $tact): self
    {
        $this->tact = $tact;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getFirstPart(): ?int
    {
        return $this->firstPart;
    }

    /**
     * @param mixed $firstPart
     *
     * @return self
     */
    public function setFirstPart($firstPart): self
    {
        $this->firstPart = $firstPart;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSecondPart(): ?int
    {
        return $this->secondPart;
    }

    /**
     * @param int $secondPart
     *
     * @return Metronome
     */
    public function setSecondPart(int $secondPart): self
    {
        $this->secondPart = $secondPart;

        return $this;
    }
}
