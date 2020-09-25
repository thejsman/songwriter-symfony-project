<?php

namespace AppBundle\EventListener\Entity;

use AppBundle\Entity\File;
use Doctrine\ORM\Event\OnFlushEventArgs;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;

/**
 * Class FileListener.
 */
class FileListener
{
    /**
     * @var FilesystemInterface
     */
    private $flysystemAttachments;

    /**
     * FileListener constructor.
     *
     * @param FilesystemInterface $flysystemAttachments
     */
    public function __construct(FilesystemInterface $flysystemAttachments)
    {
        $this->flysystemAttachments = $flysystemAttachments;
    }

    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $entities = $args->getEntityManager()->getUnitOfWork()->getScheduledEntityDeletions();

        foreach ($entities as $entity) {
            if ($entity instanceof File) {
                try {
                    $this->flysystemAttachments->delete($entity->getPath());
                } catch (FileNotFoundException $e) {
                    continue;
                }
            }
        }
    }
}
