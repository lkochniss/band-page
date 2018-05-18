<?php


namespace App\Listener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class LoginSuccessListener
 */
class LoginSuccessListener
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $user->setLastLogin();

        $this->em->persist($user);
        $this->em->flush();
    }
}
