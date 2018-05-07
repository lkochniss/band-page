<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Gig;

/**
 * Class GigRepository
 */
class GigRepository extends AbstractRepository
{

    public function findAllActiveGigsSortedByDate(): array
    {
        $now = new \DateTime();
        $query = $this->createQueryBuilder('gig')
            ->where('gig.date > :now' )
            ->setParameter('now', $now)
            ->orderBy('gig.date', 'DESC')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param AbstractEntity $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(AbstractEntity $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @return string
     */
    protected function getEntity(): string
    {
        return Gig::class;
    }
}
