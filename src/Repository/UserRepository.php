<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Log;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\User as Admin;

/**
 * Class UserRepository
 */
class UserRepository extends AbstractRepository implements UserLoaderInterface
{

    /**
     * @param string $username
     * @return mixed|null|\Symfony\Component\Security\Core\User\UserInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
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
            'User %s created/updated the user %s with email %s and role %s',
            $user->getUsername(),
            $entity->getUsername(),
            $entity->getEmail(),
            \GuzzleHttp\json_encode($entity->getRoles())
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
        return User::class;
    }
}
