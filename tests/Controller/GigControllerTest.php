<?php

namespace App\Tests\Controller;

class GigControllerTest extends AbstractControllerTest
{
    /**
     * @return array
     */
    public function frontendUrlProvider(): array
    {
        $now = new \DateTime();
        $new = new \DateTime('+10 days');
        $old = new \DateTime('-5 days');
        
        return [
            ['/gig'],
            ['/gig/past'],
            [sprintf('/gig/%s-gig-1', $now->format('Y-m-d'))],
            [sprintf('/gig/%s-gig-2', $new->format('Y-m-d'))],
            [sprintf('/gig/%s-gig-3', $old->format('Y-m-d'))],
        ];
    }

    /**
     * @return array
     */
    public function notFoundUrlProvider(): array
    {
        return [
            ['/gig/1'],
            ['/admin/gig/edit/10']
        ];
    }

    /**
     * @return array
     */
    public function backendUrlProvider(): array
    {
        return [
            ['/admin/gig'],
            ['/admin/gig/create'],
            ['/admin/gig/3/edit'],
        ];
    }
}
