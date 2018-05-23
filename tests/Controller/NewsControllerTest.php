<?php

namespace App\Tests\Controller;


class NewsControllerTest extends AbstractControllerTest
{
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
