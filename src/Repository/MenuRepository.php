<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Menu;
use App\Entity\User;
use Symfony\Component\Security\Core\User\User as Admin;

/**
 * Class MenuRepository
 */
class MenuRepository extends AbstractRepository
{
    /**
     * @param string $type
     * @return Menu
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function findOneByTypeOrCreate(string $type): Menu
    {
        /**
         * @var Menu
         */
        $menu = $this->findOneBy(['type' => $type]);

        if (is_null($menu)) {
            $menu = new Menu($type);
            $this->save($menu);
        }

        return $menu;
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
        return Menu::class;
    }
}
