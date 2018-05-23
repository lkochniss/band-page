<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MenuControllerTest extends WebTestCase
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
     * @dataProvider backendGetUrlProvider
     */
    public function testBackendBlogGetActionsReturnOkForAdminUser(string $url): void
    {
        $client = static::createClient();
        $this->loginHelper->loginAsAdmin($client);
        $client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     * @dataProvider backendGetUrlProvider
     */
    public function testBackendBlogGetActionsReturnOkForDefaultUser(string $url): void
    {
        $client = static::createClient();
        $this->loginHelper->logInAsUser($client);
        $client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     * @dataProvider backendGetUrlProvider
     */
    public function testBackendBlogGetActionsWithoutCredentialsRedirectsToLogin(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $crawler = $client->followRedirect();

        $this->assertContains('/admin/login', $crawler->getUri());
    }

    /**
     * @return array
     */
    public function backendGetUrlProvider(): array
    {
        return [
            ['/admin/main-menu'],
            ['/admin/footer-menu'],
        ];
    }

    /**
     * @param string $url
     * @dataProvider backendPostUrlProvider
     */
    public function testBackendBlogPostActionsReturnOkForAdminUser(string $url): void
    {
        $client = static::createClient();
        $this->loginHelper->loginAsAdmin($client);
        $client->request('POST', $url, ['changeset' => \GuzzleHttp\json_encode(['2','1'])]);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     * @dataProvider backendPostUrlProvider
     */
    public function testBackendBlogPostActionsReturnOkForDefaultUser(string $url): void
    {
        $client = static::createClient();
        $this->loginHelper->logInAsUser($client);
        $client->request('POST', $url, ['changeset' => \GuzzleHttp\json_encode(['1','2'])]);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     * @dataProvider backendPostUrlProvider
     */
    public function testBackendBlogPostActionsWithoutCredentialsRedirectsToLogin(string $url): void
    {
        $client = static::createClient();
        $client->request('POST', $url, ['changeset' => \GuzzleHttp\json_encode(['2','1'])]);
        $crawler = $client->followRedirect();

        $this->assertContains('/admin/login', $crawler->getUri());
    }

    /**
     * @return array
     */
    public function backendPostUrlProvider(): array
    {
        return [
            ['/admin/main-menu/update'],
            ['/admin/footer-menu/update'],
        ];
    }
}
