<?php

namespace App\Repository;

use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class LogRepository
 */
class LogRepository extends ServiceEntityRepository
{
    /**
     * LogRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Log::class);
    }

    /**
     * @param Log $log
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Log $log): void
    {
        $this->getEntityManager()->persist($log);
        $this->getEntityManager()->flush($log);
    }
}
