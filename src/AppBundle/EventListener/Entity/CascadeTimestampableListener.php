<?php

namespace AppBundle\EventListener\Entity;

use AppBundle\Entity\CascadeUpdatedAtInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;

/**
 * Class CascadeTimestampableListener.
 */
class CascadeTimestampableListener
{
    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof CascadeUpdatedAtInterface) {
                $entity->setUpdatedAtCascade(new \DateTime(), $em);
            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof CascadeUpdatedAtInterface) {
                $entity->setUpdatedAtCascade(new \DateTime(), $em);
            }
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if ($entity instanceof CascadeUpdatedAtInterface) {
                $entity->setUpdatedAtCascade(new \DateTime(), $em);
            }
        }
    }
}
