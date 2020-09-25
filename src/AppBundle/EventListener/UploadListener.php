<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\File;
use Doctrine\ORM\EntityManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Oneup\UploaderBundle\Uploader\Response\AbstractResponse;

/**
 * Class UploadListener.
 */
class UploadListener
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * UploadListener constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param PostPersistEvent $event
     *
     * @return AbstractResponse
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onUpload(PostPersistEvent $event)
    {
        /** @var AbstractResponse $response */
        $response = $event->getResponse();
        $request = $event->getRequest();

        /** @var \Symfony\Component\HttpFoundation\File\File $originalFile */
        $originalFile = $request->files->get('file');

        $data = $event->getFile();

        $metadata = $data->getFilesystem()
            ->getAdapter()
            ->getMetadata($data->getPath());

        $fileObject = new File();

        $fileObject
            ->setExternalId($request->get('externalId'))
            ->setOriginalFileName($originalFile->getClientOriginalName())
            ->setName($request->get('name'))
            ->setPath($data->getPath())
            ->setDuration($request->get('duration'))
            ->setContentType($metadata['mimetype'])
            ->setSize($metadata['size']);

        $this->em->persist($fileObject);
        $this->em->flush();

        $response->offsetSet('id', $fileObject->getId());
        $response->offsetSet('name', $fileObject->getName());
        $response->offsetSet('originalFileName', $fileObject->getOriginalFileName());
        $response->offsetSet('context', $fileObject->getContext());
        $response->offsetSet('contentType', $fileObject->getContentType());
        $response->offsetSet('path', $fileObject->getPath());
        $response->offsetSet('duration', $fileObject->getDuration());
        $response->offsetSet('size', $fileObject->getSize());
        $response->offsetSet('createdAt', $fileObject->getCreatedAt());
        $response->offsetSet('updatedAt', $fileObject->getUpdatedAt());
        $response->offsetSet('externalId', $fileObject->getExternalId());

        return $response;
    }
}
