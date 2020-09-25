<?php

namespace AppBundle\Security\Authorization;

use AppBundle\Entity\File;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class FileOwnerVoter.
 */
class FileOwnerVoter extends OwnerVoter
{
    /**
     * {@inheritdoc}
     */
    protected function voteOnEntity($attribute, $entity, UserInterface $user = null)
    {
        if (!$entity instanceof File) {
            throw new \InvalidArgumentException(sprintf('Expect entity type %s but %s type given', File::class, get_class($entity)));
        }

        return null !== $entity->getSongField() && parent::voteOnEntity($attribute, $entity, $user);
    }
}
