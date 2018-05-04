<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomepageController
 */
class HomepageController extends Controller
{
    /**
     * @return Response
     */
    public function backendDashboard(): Response {
        return $this->render('Homepage/backend-dashboard.html.twig', []);
    }
}
