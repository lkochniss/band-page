<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Menu;

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
        return Menu::class;
    }
}
