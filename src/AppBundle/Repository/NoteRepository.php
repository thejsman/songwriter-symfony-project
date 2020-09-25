<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Requestum\ApiBundle\Repository\ApiRepositoryTrait;
use Requestum\ApiBundle\Repository\FilterableRepositoryInterface;

/**
 * Class NoteRepository
 */
class NoteRepository extends EntityRepository implements FilterableRepositoryInterface
{
    use ApiRepositoryTrait;
}
