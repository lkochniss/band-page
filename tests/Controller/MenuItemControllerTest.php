<?php

namespace App\Tests\Controller;

class MenuItemControllerTest extends AbstractControllerTest
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
            ['/admin/menu/1/item/10/edit'],
            ['/admin/menu/10/item/create'],
            ['/admin/menu/10/item/10/edit'],
        ];
    }

    /**
     * @return array
     */
    public function backendUrlProvider(): array
    {
        return [
            ['/admin/menu/1/item/create'],
            ['/admin/menu/1/item/1/edit'],
        ];
    }
}
