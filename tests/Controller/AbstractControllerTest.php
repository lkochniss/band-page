<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractControllerTest extends WebTestCase
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
     * @dataProvider frontendUrlProvider
     */
    public function testFrontendBlogActionsReturnOk(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     * @dataProvider backendUrlProvider
     */
    public function testBackendBlogActionsReturnOkForAdminUser(string $url): void
    {
        $client = static::createClient();
        $this->loginHelper->loginAsAdmin($client);
        $client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     * @dataProvider backendUrlProvider
     */
    public function testBackendBlogActionsReturnOkForDefaultUser(string $url): void
    {
        $client = static::createClient();
        $this->loginHelper->logInAsUser($client);
        $client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     * @dataProvider backendUrlProvider
     */
    public function testBackendBlogActionsWithoutCredentialsRedirectsToLogin(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $crawler = $client->followRedirect();

        $this->assertContains('/admin/login', $crawler->getUri());
    }

    /**
     * @return array
     */
    abstract public function frontendUrlProvider(): array;

    /**
     * @return array
     */
    abstract public function backendUrlProvider(): array;
}
