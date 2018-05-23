<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    /**
     * @var LoginHelper
     */
    private $loginHelper;

    public function setUp()
    {
        $this->loginHelper = new LoginHelper();
    }

    /**
     * @param string $url
     * @dataProvider backendAdminUrlProvider
     */
    public function testBackendUserActionsReturnOkForAdminUser(string $url): void
    {
        $client = static::createClient();
        $this->loginHelper->loginAsAdmin($client);
        $client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     * @dataProvider backendAdminUrlProvider
     */
    public function testBackendUserActionsWithoutCredentialsRedirectsToLogin(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $crawler = $client->followRedirect();

        $this->assertContains('/admin/login', $crawler->getUri());
    }

    /**
     * @return array
     */
    public function backendAdminUrlProvider(): array
    {
        return [
            ['/admin/user/create'],
            ['/admin/user/1/edit'],
            ['/admin/password/reset'],
            ['/admin/user'],
        ];
    }

    /**
     * @param string $url
     * @dataProvider backendUserUrlProvider
     */
    public function testBackendUserActionsReturnForbiddenForDefaultUser(string $url): void
    {
        $client = static::createClient();
        $this->loginHelper->logInAsUser($client);
        $client->request('GET', $url);

        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    public function testPasswordResetReturnsOkForDefaultUser(): void
    {
        $client = static::createClient();
        $this->loginHelper->logInAsUser($client);
        $client->request('GET', '/admin/password/reset');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function backendUserUrlProvider(): array
    {
        return [
            ['/admin/user/create'],
            ['/admin/user/1/edit'],
            ['/admin/user'],
        ];
    }


}
