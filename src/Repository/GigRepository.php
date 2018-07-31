<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Entity\Gig;
use App\Entity\Log;
use App\Entity\User;
use Symfony\Component\Security\Core\User\User as Admin;

/**
 * Class GigRepository
 */
class GigRepository extends AbstractRepository
{

    public function findAllUpcomingGigsSortedByDate(): array
    {
        $now = new \DateTime('now 00:00:00');
        $query = $this->createQueryBuilder('gig')
            ->where('gig.date > :now')
            ->setParameter('now', $now)
            ->orderBy('gig.date', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    public function findAllPastGigsSortedByDate(): array
    {
        $now = new \DateTime('now 00:00:00');
        $query = $this->createQueryBuilder('gig')
            ->where('gig.date < :now')
            ->setParameter('now', $now)
            ->orderBy('gig.date', 'DESC')
            ->getQuery();

        return $query->getResult();
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
            'User %s created/updated the gig %s with description %s, 
            date %s, doors open %s, a price of %s %s at location %s',
            $user->getUsername(),
            $entity->getTitle(),
            $entity->getDescription(),
            $entity->getDate()->format('d.m.Y'),
            $entity->getDate()->format('H:i'),
            $entity->getPrice(),
            getenv('DEFAULT_CURRENCY'),
            $entity->getLocation()->getName()
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
            'User %s deleted the gig %s with description %s, 
            date %s, doors open %s, a price of %s %s at location %s',
            $user->getUsername(),
            $entity->getTitle(),
            $entity->getDescription(),
            $entity->getDate()->format('d.m.Y'),
            $entity->getDate()->format('H:i'),
            $entity->getPrice(),
            getenv('DEFAULT_CURRENCY'),
            $entity->getLocation()->getName()
        ));

        $this->logRepository->save($log);
    }

    /**
     * @return string
     */
    protected function getEntity(): string
    {
        return Gig::class;
    }
}
