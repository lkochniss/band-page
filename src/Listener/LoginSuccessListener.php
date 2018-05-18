<?php


namespace App\Listener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class LoginSuccessListener
 */
class LoginSuccessListener
{
    private $entityManager;

    /**
     * LoginSuccessListener constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof User === false) {
            return;
        }

        $user->setLastLogin();

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
