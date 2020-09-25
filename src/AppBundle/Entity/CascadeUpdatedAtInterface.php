<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Interface CascadeUpdatedAt.
 */
interface CascadeUpdatedAtInterface
{
    /**
     * @param \DateTime              $updatedAt
     * @param EntityManagerInterface $em
     */
    public function setUpdatedAtCascade(\DateTime $updatedAt, EntityManagerInterface $em);
}
