<?php

namespace AuthBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Requestum\ApiBundle\Repository\ApiRepositoryTrait;
use Requestum\ApiBundle\Repository\FilterableRepositoryInterface;

/**
 * Class AccessTokenRepository.
 */
class AccessTokenRepository extends EntityRepository implements FilterableRepositoryInterface
{
    use ApiRepositoryTrait;
}
