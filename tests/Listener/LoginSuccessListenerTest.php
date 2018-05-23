<?php

namespace App\Tests\Listener;

use App\Listener\LoginSuccessListener;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginSuccessListenerTest extends TestCase
{
    public function testLoginSuccessOnUserEntityAddsLastLogin(): void
    {
        $user = new \App\Entity\User();
        $user->setUsername('Test User');
        $user->setPassword('Test Password');
        $user->setEmail('Test Mail');
        $user->setRoles([\App\Entity\User::ROLE_USER]);

        $token = $this->createMock(TokenInterface::class);
        $token->expects($this->any())
            ->method('getUser')
            ->willReturn($user);

        $event = $this->createMock(InteractiveLoginEvent::class);
        $event->expects($this->any())
            ->method('getAuthenticationToken')
            ->willReturn($token);

        $manager = $this->createMock(EntityManagerInterface::class);

        $loginSuccessListener = new LoginSuccessListener($manager);

        $loginSuccessListener->onSecurityInteractiveLogin($event);

        $this->assertNotNull($user->getLastLogin());
    }

    public function testLoginSuccessOnWrongEntityReturns(): void
    {
        $user = new \Symfony\Component\Security\Core\User\User('admin', 'admin', ['ROLE_ADMIN']);

        $token = $this->createMock(TokenInterface::class);
        $token->expects($this->any())
            ->method('getUser')
            ->willReturn($user);

        $event = $this->createMock(InteractiveLoginEvent::class);
        $event->expects($this->any())
            ->method('getAuthenticationToken')
            ->willReturn($token);

        $manager = $this->createMock(EntityManagerInterface::class);
        $manager->expects($this->never())
            ->method('persist')
            ->with($user);

        $manager->expects($this->never())
            ->method('flush');

        $loginSuccessListener = new LoginSuccessListener($manager);

        $loginSuccessListener->onSecurityInteractiveLogin($event);

        // The test itself is that the manager functions aren't triggered
        $this->assertTrue(true);
    }
}
