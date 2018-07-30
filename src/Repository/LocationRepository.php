<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Location;
use App\Entity\Log;
use App\Entity\User;
use Symfony\Component\Security\Core\User\User as Admin;

/**
 * Class LocationRepository
 */
class LocationRepository extends AbstractRepository
{
    /**
     * @param AbstractEntity $entity
     * @param User|Admin $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(AbstractEntity $entity, $user): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        $log = new Log();
        $log->setMessage(sprintf(
            'User %s created/updated the location %s with street %s, city %s and zip %s',
            $user->getUsername(),
            $entity->getName(),
            $entity->getStreet(),
            $entity->getCity(),
            $entity->getZip()
        ));

        $this->logRepository->save($log);
    }

    /**
     * @param AbstractEntity $entity
     * @param User|Admin $user
     */
    public function remove(AbstractEntity $entity, $user): void
    {
        //TODO
    }

    /**
     * @return string
     */
    protected function getEntity(): string
    {
        return Location::class;
    }
}
