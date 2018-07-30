<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Image;
use App\Entity\Log;
use App\Entity\User;
use Symfony\Component\Security\Core\User\User as Admin;

/**
 * Class ImageRepository
 */
class ImageRepository extends AbstractRepository
{

    /**
     * @param AbstractEntity $entity
     * @param User|Admin $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(AbstractEntity $entity, $user): void
    {
        $entity->upload();
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        $log = new Log();
        $log->setMessage(sprintf(
            'User %s created/updated the image %s with path %s',
            $user->getUsername(),
            $entity->getName(),
            $entity->getFullPath()
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
        return Image::class;
    }
}
