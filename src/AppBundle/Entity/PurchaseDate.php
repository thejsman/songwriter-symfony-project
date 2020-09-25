<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class PurchaseDate
{
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups("default")
     */
    private $expiresDate;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\NotBlank(groups={"Receipt"})
     *
     */
    private $receiptData;

    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->getExpiresDate() < new \DateTime();
    }

    /**
     * @return \DateTime|null
     */
    public function getExpiresDate(): ?\DateTime
    {
        return $this->expiresDate;
    }

    /**
     * @param \DateTime $expiresDate
     *
     * @return self
     */
    public function setExpiresDate(\DateTime $expiresDate): self
    {
        $this->expiresDate = $expiresDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReceiptData(): ?string
    {
        return $this->receiptData;
    }

    /**
     * @param string $receiptData
     *
     * @return self
     */
    public function setReceiptData(string $receiptData): self
    {
        $this->receiptData = $receiptData;

        return $this;
    }
}
