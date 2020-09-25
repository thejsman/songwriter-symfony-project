<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\EntityListeners({"AppBundle\EventListener\UserListener"})
 *
 * @UniqueEntity(fields={"email"}, groups={"Default", "Social"})
 */
class User implements UserInterface
{
    use TimestampableEntity;

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
     * @var string User name
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank
     *
     * @Groups("default")
     */
    private $name = '';

    /**
     * @var string User email
     *
     * @ORM\Column(type="string", unique=true)
     *
     * @Assert\NotBlank
     * @Assert\Email()
     *
     * @Groups("default")
     */
    private $email;

    /**
     * @var string encrypted password
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $password;

    /**
     * @var string encrypted password
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank
     */
    protected $plainPassword;

    /**
     * @var string User level
     *
     * @ORM\Column(type="boolean")
     *
     * @Groups("default")
     */
    private $enabled = true;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $confirmationToken;

    /**
     * @ORM\Embedded(class="AppBundle\Entity\PurchaseDate")
     *
     * @Assert\Valid()
     *
     * @Groups("default")
     */
    private $purchaseDate;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Folder", mappedBy="user", cascade={"all"})
     *
     * @Groups("default")
     */
    private $folders;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $externalService;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $externalServiceId;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $artistName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $primaryGenre;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $secondaryGenre;

    /**
     * @var array|null
     *
     * @ORM\Column(type="json_array", nullable=true)
     *
     * @Groups("default")
     */
    private $descriptions;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->folders = new ArrayCollection();

        $folder = new Folder();
        $folder->setName('11XxALLSONGSxX11');
        $this->addFolder($folder);
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
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->email;
    }

    /**
     * @return null|string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        if ($this->getPurchaseDate()->isExpired()) {
            return ['ROLE_USER'];
        }

        return ['ROLE_PAID_USER'];
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPlainPassword(string $password): self
    {
        $this->plainPassword = $password;
        $this->password = null;

        return $this;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return bool|string
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $boolean
     *
     * @return self
     */
    public function setEnabled(bool $boolean): self
    {
        $this->enabled = $boolean;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    /**
     * @param string $confirmationToken
     *
     * @return self
     */
    public function setConfirmationToken(string $confirmationToken = null)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * @return PurchaseDate|null
     */
    public function getPurchaseDate(): ?PurchaseDate
    {
        return $this->purchaseDate;
    }

    /**
     * @param PurchaseDate $purchaseDate
     *
     * @return self
     */
    public function setPurchaseDate(PurchaseDate $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFolders(): Collection
    {
        return $this->folders;
    }

    /**
     * @param Folder $folder
     *
     * @return self
     */
    public function addFolder(Folder $folder): self
    {
        if (!$this->folders->contains($folder)) {
            $folder->setUser($this);
            $this->folders->add($folder);
        }

        return $this;
    }

    /**
     * @param Folder $folder
     *
     * @return self
     */
    public function removeFolder(Folder $folder): self
    {
        $this->folders->remove($folder);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalService(): ?string
    {
        return $this->externalService;
    }

    /**
     * @param string $externalService
     *
     * @return self
     */
    public function setExternalService(string $externalService): self
    {
        $this->externalService = $externalService;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalServiceId(): ?string
    {
        return $this->externalServiceId;
    }

    /**
     * @param string $externalServiceId
     *
     * @return self
     */
    public function setExternalServiceId(string $externalServiceId): self
    {
        $this->externalServiceId = $externalServiceId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getArtistName(): ?string
    {
        return $this->artistName;
    }

    /**
     * @param string $artistName
     *
     * @return self
     */
    public function setArtistName(?string $artistName): self
    {
        $this->artistName = $artistName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrimaryGenre(): ?string
    {
        return $this->primaryGenre;
    }

    /**
     * @param string $primaryGenre
     *
     * @return self
     */
    public function setPrimaryGenre(?string $primaryGenre): self
    {
        $this->primaryGenre = $primaryGenre;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSecondaryGenre(): ?string
    {
        return $this->secondaryGenre;
    }

    /**
     * @param string $secondaryGenre
     *
     * @return self
     */
    public function setSecondaryGenre(?string $secondaryGenre): self
    {
        $this->secondaryGenre = $secondaryGenre;

        return $this;
    }

    /**
     * @return array
     */
    public function getDescriptions(): ?array
    {
        return $this->descriptions;
    }

    /**
     * @param array $descriptions
     *
     * @return self
     */
    public function setDescriptions(?array $descriptions): self
    {
        $this->descriptions = $descriptions;

        return $this;
    }
}
