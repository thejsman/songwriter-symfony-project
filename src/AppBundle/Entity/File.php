<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ExternalResource;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\UnitOfWork;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * File.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FileRepository")
 */
class File implements CascadeUpdatedAtInterface
{
    use TimestampableEntity;
    use ExternalResource;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups("default")
     */
    private $id;

    /**
     * @var string Media name
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $context;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    protected $contentType;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $size;

    /**
     * @var string Media path
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $originalFileName;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups("default")
     */
    private $duration = 0;

    /**
     * @var SongField
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SongField", inversedBy="audio")
     */
    private $songField;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set context.
     *
     * @param string $context
     *
     * @return $this
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get context.
     *
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set contentType.
     *
     * @param string $contentType
     *
     * @return $this
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get contentType.
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set size.
     *
     * @param int $size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getOriginalFileName()
    {
        return $this->originalFileName;
    }

    /**
     * @param string $originalFileName
     *
     * @return self
     */
    public function setOriginalFileName($originalFileName): self
    {
        $this->originalFileName = $originalFileName;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @param int|null $duration
     *
     * @return self
     */
    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

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

    /**
     * @param \DateTime              $updatedAt
     * @param EntityManagerInterface $em
     *
     * @return File
     */
    public function setUpdatedAtCascade(\DateTime $updatedAt, EntityManagerInterface $em): self
    {
        $this->updatedAt = $updatedAt;

        $uow = $em->getUnitOfWork();

        if (null !== $this->songField && $uow->getEntityState($this->songField) === UnitOfWork::STATE_MANAGED) {
            $this->songField->setUpdatedAtCascade($updatedAt, $em);

            $metadata = $em->getClassMetadata(get_class($this->songField));
            $uow->recomputeSingleEntityChangeSet($metadata, $this->songField);
        }

        return $this;
    }
}
