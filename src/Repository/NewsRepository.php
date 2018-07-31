<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Log;
use App\Entity\News;
use App\Entity\User;
use Symfony\Component\Security\Core\User\User as Admin;

/**
 * Class NewsRepository
 */
class NewsRepository extends AbstractRepository
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
            'User %s created/updated the news %s with content %s',
            $user->getUsername(),
            $entity->getTitle(),
            $entity->getContent()
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
            'User %s deleted the news %s with content %s',
            $user->getUsername(),
            $entity->getTitle(),
            $entity->getContent()
        ));

        $this->logRepository->save($log);
    }

    /**
     * @return string
     */
    protected function getEntity(): string
    {
        return News::class;
    }
}
