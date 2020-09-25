<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ExternalResource;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Idea.
 *
 * @ORM\Table(name="ideas")
 * @ORM\Entity
 */
class Idea implements CascadeUpdatedAtInterface
{
    use TimestampableEntity;
    use ExternalResource;

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
     * @Groups("default")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank
     *
     * @Groups("default")
     */
    private $text;

    /**
     * @var Song
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Song", inversedBy="ideas")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $song;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type): self
    {
        if (!\in_array($type, IdeaTypes::TYPES)) {
            throw new \InvalidArgumentException(\sprintf('Unknown idea type "%s" known: %s', $type, IdeaTypes::getTypesAsString()));
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string $category
     *
     * @return self
     */
    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return self
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Song|null
     */
    public function getSong(): ?Song
    {
        return $this->song;
    }

    /**
     * @param Song $song
     *
     * @return self
     */
    public function setSong(Song $song): self
    {
        $this->song = $song;

        return $this;
    }

    /**
     * @param \DateTime              $updatedAt
     * @param EntityManagerInterface $em
     *
     * @return $this
     */
    public function setUpdatedAtCascade(\DateTime $updatedAt, EntityManagerInterface $em)
    {
        $this->updatedAt = $updatedAt;
        $this->song->setUpdatedAt($updatedAt);

        $metadata = $em->getClassMetadata(get_class($this->song));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($metadata, $this->song);

        return $this;
    }
}
