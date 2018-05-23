<?php

namespace App\Tests\Controller;

class HomepageControllerTest extends AbstractControllerTest
{
    /**
     * @return array
     */
    public function frontendUrlProvider(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function notFoundUrlProvider(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function backendUrlProvider(): array
    {
        return [
            ['/admin/'],
        ];
    }
}
