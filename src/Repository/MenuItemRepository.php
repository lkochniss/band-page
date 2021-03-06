<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Log;
use App\Entity\MenuItem;
use App\Entity\User;
use Symfony\Component\Security\Core\User\User as Admin;

/**
 * Class MenuItemRepository
 */
class MenuItemRepository extends AbstractRepository
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
            'User %s created/updated a menu item for the page %s in the %s menu on position %s',
            $user->getUsername(),
            $entity->getPage()->getTitle(),
            $entity->getMenu()->getType(),
            $entity->getPosition()
        ));

        $this->logRepository->save($log);
    }

    /**
     * @param AbstractEntity $entity
     * @param User|Admin $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(AbstractEntity $entity, $user): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush($entity);

        $log = new Log();
        $log->setMessage(sprintf(
            'User %s removed a menu item for the page %s in the %s menu on position %s',
            $user->getUsername(),
            $entity->getPage()->getTitle(),
            $entity->getMenu()->getType(),
            $entity->getPosition()
        ));

        $this->logRepository->save($log);
    }

    /**
     * @return string
     */
    protected function getEntity(): string
    {
        return MenuItem::class;
    }
}
