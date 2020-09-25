<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ExternalResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Requestum\ApiBundle\Rest\Metadata\Reference;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="songs")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SongRepository")
 *
 * @Gedmo\SoftDeleteable()
 */
class Song
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
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
     * @var string Song name
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank
     *
     * @Groups("default")
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $deviceId;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $deviceModel;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     *
     * @Groups("default")
     */
    private $orderNumber;

    /**
     * @var Folder
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Folder", inversedBy="songs")
     * @ORM\JoinColumn(nullable=false, onDelete="SET NULL")
     *
     * @Groups("default")
     *
     * @Reference()
     */
    private $folder;

    /**
     * @var Note
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Note", mappedBy="song", cascade={"all"})
     *
     * @Assert\NotBlank
     *
     * @Groups("default")
     */
    private $note;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SongField", mappedBy="song", cascade={"persist", "remove"}, orphanRemoval=true, fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Groups("default")
     */
    private $fields;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Idea", mappedBy="song", cascade={"persist", "remove"}, orphanRemoval=true, fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Assert\Valid
     *
     * @Groups("default")
     */
    private $ideas;

    /**
     * Song constructor.
     */
    public function __construct()
    {
        $this->setNote(new Note());
        $this->fields = new ArrayCollection();
        $this->ideas = new ArrayCollection();
    }

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    /**
     * @param string|null $deviceId
     *
     * @return self
     */
    public function setDeviceId(?string $deviceId): self
    {
        if (null === $this->deviceId) {
            $this->deviceId = $deviceId;
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceModel(): ?string
    {
        return $this->deviceModel;
    }

    /**
     * @param string|null $deviceModel
     *
     * @return self
     */
    public function setDeviceModel(?string $deviceModel): self
    {
        if (null === $this->deviceModel) {
            $this->deviceModel = $deviceModel;
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    /**
     * @param int $orderNumber
     *
     * @return self
     */
    public function setOrderNumber(int $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @return Folder|null
     */
    public function getFolder(): ?Folder
    {
        return $this->folder;
    }

    /**
     * @param Folder $folder
     *
     * @return self
     */
    public function setFolder(Folder $folder): self
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return Note|null
     */
    public function getNote(): ?Note
    {
        return $this->note;
    }

    /**
     * @param Note $note
     *
     * @return self
     */
    public function setNote(Note $note): self
    {
        $note->setSong($this);
        $this->note = $note;

        return $this;
    }

    /**
     * @param Collection $fields
     *
     * @return Song
     */
    public function setFields(Collection $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    /**
     * @param SongField $field
     *
     * @return self
     */
    public function addField(SongField $field): self
    {
        if (!$this->fields->contains($field)) {
            $field->setSong($this);
            $this->fields->add($field);
        }

        return $this;
    }

    /**
     * @param SongField $field
     *
     * @return self
     */
    public function removeField(SongField $field): self
    {
        $this->fields->removeElement($field);

        return $this;
    }

    /**
     * @param Collection $ideas
     *
     * @return self
     */
    public function setIdeas(Collection $ideas): self
    {
        $this->ideas = $ideas;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getIdeas(): Collection
    {
        return $this->ideas;
    }

    /**
     * @param Idea $idea
     *
     * @return self
     */
    public function addIdea(Idea $idea): self
    {
        if (!$this->ideas->contains($idea)) {
            $this->ideas->add($idea);
            $idea->setSong($this);
        }

        return $this;
    }

    /**
     * @param Idea $idea
     *
     * @return self
     */
    public function removeIdea(Idea $idea): self
    {
        $this->ideas->removeElement($idea);

        return $this;
    }

    /**
     * @return \DateTime
     *
     * @Groups("default")
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     *
     * @Groups("default")
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return \DateTime|null
     *
     * @Groups("default")
     */
    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }
}
