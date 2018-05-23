<?php


namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class LoginHelper
{
    public function logInAsAdmin(Client &$client)
    {
        $session = $client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'admin';

        $token = new UsernamePasswordToken(
            getenv('USER_NAME'),
            getenv('USER_PASS'),
            $firewallContext,
            [User::ROLE_ADMIN]
        );

        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    public function logInAsUser(Client &$client)
    {
        $session = $client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'admin';

        $token = new UsernamePasswordToken(
            getenv('USER_NAME'),
            getenv('USER_PASS'),
            $firewallContext,
            [User::ROLE_USER]
        );

        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }
}
