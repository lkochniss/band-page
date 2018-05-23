<?php

namespace App\Tests\Controller;

class FilemanagerControllerTest extends AbstractControllerTest
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
            ['/admin/filemanager/create/directory/1'],
            ['/admin/filemanager/upload/image/1'],
            ['/admin/filemanager/1'],
        ];
    }
}
