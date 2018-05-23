<?php

namespace App\Tests\Controller;

class PageControllerTest extends AbstractControllerTest
{
    /**
     * @return array
     */
    public function frontendUrlProvider(): array
    {
        return [
            ['/page/page-1'],
            ['/page/page-2'],
            ['/page/page-3']
        ];
    }

    /**
     * @return array
     */
    public function backendUrlProvider(): array
    {
        return [
            ['/admin/page'],
            ['/admin/page/create'],
            ['/admin/page/3/edit'],
        ];
    }
}
