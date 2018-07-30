<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\User\User as Admin;

/**
 * Class AbstractRepository
 */
abstract class AbstractRepository extends ServiceEntityRepository
{

    /**
     * @var LogRepository
     */
    protected $logRepository;

    /**
     * AbstractRepository constructor.
     * @param RegistryInterface $registry
     * @param LogRepository $logRepository
     */
    public function __construct(RegistryInterface $registry, LogRepository $logRepository)
    {
        parent::__construct($registry, $this->getEntity());
        $this->logRepository = $logRepository;
    }

    /**
     * @param AbstractEntity $entity
     * @param User|Admin $user
     */
    abstract public function save(AbstractEntity $entity, $user): void;

    /**
     * @param AbstractEntity $entity
     * @param User|Admin $user
     */
    abstract public function remove(AbstractEntity $entity, $user): void;

    /**
     * @return string
     */
    abstract protected function getEntity(): string;
}
