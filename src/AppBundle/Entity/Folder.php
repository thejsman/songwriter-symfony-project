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
 * @ORM\Table(name="folders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FolderRepository")
 *
 * @Gedmo\SoftDeleteable()
 */
class Folder
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
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank
     *
     * @Groups("default")
     */
    private $name;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Song", mappedBy="folder", cascade={"all"})
     *
     * @Groups("default")
     *
     * @Reference()
     */
    private $songs;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="folders")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     *
     * @Groups("default")
     *
     * @Reference()
     */
    private $user;

    /**
     * Folder constructor.
     */
    public function __construct()
    {
        $this->songs = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    /**
     * @param Song $song
     *
     * @return self
     */
    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $song->setFolder($this);
            $this->songs->add($song);
        }

        return $this;
    }

    /**
     * @param Song $song
     *
     * @return self
     */
    public function removeSong(Song $song): self
    {
        $this->songs->remove($song);

        return $this;
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
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTime
     *
     * @Groups("default")
     */
    public function getUpdatedAt()
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
