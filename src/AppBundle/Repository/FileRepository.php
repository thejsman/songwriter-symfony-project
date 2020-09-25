<?php

namespace AppBundle\Repository;

use Requestum\ApiBundle\Repository\ApiRepositoryTrait;
use Requestum\ApiBundle\Repository\FilterableRepositoryInterface;

/**
 * FileRepository.
 */
class FileRepository extends \Doctrine\ORM\EntityRepository implements FilterableRepositoryInterface
{
    use ApiRepositoryTrait;
}
