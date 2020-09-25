<?php

namespace AppBundle\EventListener\Form;

use AppBundle\Entity\Folder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SongFolderListener.
 */
class SongFolderListener
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * SongFolderListener constructor.
     *
     * @param EntityManagerInterface $em
     * @param UserInterface          $user
     */
    public function __construct(EntityManagerInterface $em, UserInterface $user)
    {
        $this->em = $em;
        $this->user = $user;
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $song = $event->getData();

        if (!empty($song['folder'])) {
            return;
        }

        $folder = $this->em->getRepository(Folder::class)->findOneBy([
            'name' => '11XxALLSONGSxX11',
            'user' => $this->user,
        ]);

        $event->setData($song + ['folder' => $folder->getId()]);
    }
}
