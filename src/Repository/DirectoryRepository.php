<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Directory;
use App\Entity\Log;
use App\Entity\User;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Core\User\User as Admin;

/**
 * Class DirectoryRepository
 */
class DirectoryRepository extends AbstractRepository
{
    /**
     * @param int $id
     * @return Directory
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     */
    public function findOrCreateRoot(int $id): Directory
    {
        /**
         * @var Directory
         */
        $parentDirectory = $this->find($id);

        if (is_null($parentDirectory)) {
            $parentDirectory = new Directory();
            $parentDirectory->setName('');
            $parentDirectory->setPath('upload');
            $this->save($parentDirectory);

            $filesystem = new Filesystem();
            $filesystem->mkdir($parentDirectory->getFullPath());
        }

        return $parentDirectory;
    }

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
            'User %s created/updated the directory %s with path %s',
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
        return Directory::class;
    }
}
