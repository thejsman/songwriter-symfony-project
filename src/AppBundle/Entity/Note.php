<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ExternalResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Requestum\ApiBundle\Rest\Metadata\Reference;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="notes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NoteRepository")
 */
class Note
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
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $author;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $coAuthor;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $started;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $finished;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $publisher;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $key;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $BMP;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $style;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $notes;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("default")
     */
    private $tempo;

    /**
     * @var Song
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Song", inversedBy="note")
     * @ORM\JoinColumn(name="song_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @Reference()
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
     * @return null|string
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string $author
     *
     * @return self
     */
    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCoAuthor(): ?string
    {
        return $this->coAuthor;
    }

    /**
     * @param string $coAuthor
     *
     * @return self
     */
    public function setCoAuthor(?string $coAuthor): self
    {
        $this->coAuthor = $coAuthor;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStarted(): ?string
    {
        return $this->started;
    }

    /**
     * @param string $started
     *
     * @return self
     */
    public function setStarted(?string $started): self
    {
        $this->started = $started;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFinished(): ?string
    {
        return $this->finished;
    }

    /**
     * @param string $finished
     *
     * @return self
     */
    public function setFinished(?string $finished): self
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     *
     * @return self
     */
    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return self
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBMP(): ?string
    {
        return $this->BMP;
    }

    /**
     * @param string $BMP
     *
     * @return self
     */
    public function setBMP(?string $BMP): self
    {
        $this->BMP = $BMP;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStyle(): ?string
    {
        return $this->style;
    }

    /**
     * @param string $style
     *
     * @return self
     */
    public function setStyle(?string $style): self
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     *
     * @return self
     */
    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

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
    public function setSong(?Song $song): self
    {
        $this->song = $song;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTempo(): ?string
    {
        return $this->tempo;
    }

    /**
     * @param string $tempo
     *
     * @return self
     */
    public function setTempo(?string $tempo): self
    {
        $this->tempo = $tempo;

        return $this;
    }
}
