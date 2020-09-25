<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ExternalResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Requestum\ApiBundle\Rest\Metadata\Reference;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="song_fields")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SongFieldRepository")
 */
class SongField implements CascadeUpdatedAtInterface
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
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     *
     * @Groups("default")
     */
    private $chords = [];

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups("default")
     */
    private $text;

    /**
     * @ORM\Embedded(class="AppBundle\Entity\Metronome")
     *
     * @Assert\Valid()
     *
     * @Groups("default")
     */
    private $metronome;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\File", mappedBy="songField", orphanRemoval=true, cascade={"persist", "remove"})
     *
     * @Groups("default")
     */
    private $audio;

    /**
     * @var Song
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Song", inversedBy="fields")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     *
     * @Groups("default")
     *
     * @Reference()
     */
    private $song;

    /**
     * @var SongFieldOrder
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\SongFieldOrder", mappedBy="songField", cascade={"all"})
     *
     * @Groups("default")
     */
    private $order;

    /**
     * SongField constructor.
     */
    public function __construct()
    {
        $this->audio = new ArrayCollection();

        $this->setOrder(new SongFieldOrder());
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
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
        $this->type = $type;

        return $this;
    }

    /**
     * @return array
     */
    public function getChords(): array
    {
        return $this->chords;
    }

    /**
     * @param array $chords
     *
     * @return self
     */
    public function setChords(array $chords): self
    {
        $this->chords = $chords;

        return $this;
    }

    /**
     * @return string
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
     * @param Collection $audio
     *
     * @return self
     */
    public function setAudio(Collection $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAudio(): Collection
    {
        return $this->audio;
    }

    /**
     * @param File $file
     *
     * @return self
     */
    public function addAudio(File $file): self
    {
        if (!$this->audio->contains($file)) {
            $this->audio->add($file);
            $file->setSongField($this);
        }

        return $this;
    }

    /**
     * @param File $file
     *
     * @return self
     */
    public function removeAudio(File $file): self
    {
        $this->audio->removeElement($file);

        return $this;
    }

    /**
     * @return Song
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
        if (!$this->getOrder()->getWeight()) {
            $this->getOrder()->setWeight($song->getFields()->count() + 1);
        }
        $this->song = $song;

        return $this;
    }

    /**
     * @return SongFieldOrder
     */
    public function getOrder(): ?SongFieldOrder
    {
        return $this->order;
    }

    /**
     * @param SongFieldOrder $order
     *
     * @return self
     */
    public function setOrder(SongFieldOrder $order): self
    {
        $order->setSongField($this);
        $this->order = $order;

        return $this;
    }

    /**
     * @return Metronome|null
     */
    public function getMetronome(): ?Metronome
    {
        return $this->metronome;
    }

    /**
     * @param Metronome $metronome
     *
     * @return SongField
     */
    public function setMetronome(Metronome $metronome): self
    {
        $this->metronome = $metronome;

        return $this;
    }

    /**
     * @param \DateTime              $updatedAt
     * @param EntityManagerInterface $em
     *
     * @return self
     */
    public function setUpdatedAtCascade(\DateTime $updatedAt, EntityManagerInterface $em): self
    {
        $this->updatedAt = $updatedAt;
        $this->song->setUpdatedAt($updatedAt);

        $metadata = $em->getClassMetadata(get_class($this->song));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($metadata, $this->song);

        return $this;
    }
}
