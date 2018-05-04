<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class NewsControllerTest extends WebTestCase
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
     * @return array
     */
    public function frontendUrlProvider(): array
    {
        $now = new \DateTime();
        return [
            ['/'],
            [sprintf('/news/%s-post-1', $now->format('Y-m-d'))],
            [sprintf('/news/%s-post-2', $now->format('Y-m-d'))],
            [sprintf('/news/%s-post-3', $now->format('Y-m-d'))]
        ];
    }

    /**
     * @param string $url
     * @dataProvider backendUrlProvider
     */
    public function testBackendBlogActionsReturnOk(string $url): void
    {
        $client = static::createClient();
        $this->loginHelper->logIn($client);
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
    public function backendUrlProvider(): array
    {
        return [
            ['/admin/news'],
            ['/admin/news/create'],
            ['/admin/news/3/edit'],
        ];
    }
}
