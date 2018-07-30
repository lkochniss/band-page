<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Log;
use App\Entity\Settings;
use App\Entity\User;
use Symfony\Component\Security\Core\User\User as Admin;

/**
 * Class SettingsRepository
 */
class SettingsRepository extends AbstractRepository
{
    /**
     * @param string $key
     * @return Settings
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function findOneByKeyOrCreate(string $key): Settings
    {
        /**
         * @var Settings
         */
        $settings = $this->findOneBy(['settingsKey' => $key]);

        if (is_null($settings)) {
            $settings = new Settings($key);
            $this->save($settings);
        }

        return $settings;
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
            'User %s updated the settings %s with %s',
            $user->getUsername(),
            $entity->getSettingsKey(),
            $entity->getSettingsValue()
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
        return Settings::class;
    }
}
