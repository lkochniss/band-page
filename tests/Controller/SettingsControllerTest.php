<?php

namespace App\Tests\Controller;

class SettingsControllerTest extends AbstractControllerTest
{
    /**
     * @return array
     */
    public function frontendUrlProvider(): array
    {
        return [['/']];
    }

    /**
     * @return array
     */
    public function backendUrlProvider(): array
    {
        return [
            ['/admin/settings'],
        ];
    }
}
