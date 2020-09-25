<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Requestum\ApiBundle\Repository\ApiRepositoryTrait;
use Requestum\ApiBundle\Repository\FilterableRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class FolderRepository
 */
class FolderRepository extends EntityRepository implements FilterableRepositoryInterface
{
    use ApiRepositoryTrait;

    /**
     * @param UserInterface $user
     * @param string        $deletedAt
     *
     * @return array
     */
    public function getDeletedFolders(UserInterface $user, string $deletedAt): array
    {
        $this->_em->getFilters()->disable('softdeleteable');

        $builder = $this->createQueryBuilder('f');

        $folders = $builder
            ->select('f.id')
            ->where('f.user = :user')
            ->andWhere('f.deletedAt >= :deletedAt')
            ->orderBy('f.id')
            ->setParameter('user', $user)
            ->setParameter('deletedAt', $deletedAt)
            ->getQuery()
            ->getArrayResult();

        return array_column($folders, 'id');
    }
}
