<?php

namespace App\Tests\Controller;

class LocationControllerTest extends AbstractControllerTest
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
        return [
            ['/admin/location/10/edit']
        ];
    }

    /**
     * @return array
     */
    public function backendUrlProvider(): array
    {
        return [
            ['/admin/location'],
            ['/admin/location/create'],
            ['/admin/location/1/edit'],
        ];
    }
}
