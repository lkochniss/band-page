<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Directory;
use Symfony\Component\Filesystem\Filesystem;

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
        return Directory::class;
    }
}
