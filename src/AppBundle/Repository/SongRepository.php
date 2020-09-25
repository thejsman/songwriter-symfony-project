<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Requestum\ApiBundle\Repository\ApiRepositoryTrait;
use Requestum\ApiBundle\Repository\FilterableRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SongRepository
 */
class SongRepository extends EntityRepository implements FilterableRepositoryInterface
{
    use ApiRepositoryTrait;

    /**
     * @param UserInterface $user
     * @param string        $deletedAt
     *
     * @return array
     */
    public function getDeletedSongs(UserInterface $user, string $deletedAt): array
    {
        $this->_em->getFilters()->disable('softdeleteable');

        $builder = $this->createQueryBuilder('s');

        $songs = $builder
            ->select('s.id')
            ->join('s.folder', 'f')
            ->where('f.user = :user')
            ->andWhere('s.deletedAt >= :deletedAt')
            ->orderBy('s.id')
            ->setParameter('user', $user)
            ->setParameter('deletedAt', $deletedAt)
            ->getQuery()
            ->getArrayResult();

        return array_column($songs, 'id');
    }

    /**
     * {@inheritdoc}
     */
    protected function getPathAliases()
    {
        return [
            'user' => '[folder][user]',
        ];
    }
}
