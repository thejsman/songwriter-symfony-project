<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Requestum\ApiBundle\Rest\Metadata\Reference;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="song_field_orders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SongFieldOrderRepository")
 */
class SongFieldOrder
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups("default")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank
     *
     * @Groups("default", nullable=true)
     */
    private $weight;

    /**
     * @var SongField
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\SongField", inversedBy="order")
     *
     * @Reference()
     */
    private $songField;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     *
     * @return self
     */
    public function setWeight(string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return SongField|null
     */
    public function getSongField(): ?SongField
    {
        return $this->songField;
    }

    /**
     * @param SongField $songField
     *
     * @return self
     */
    public function setSongField(SongField $songField): self
    {
        $this->songField = $songField;

        return $this;
    }
}
