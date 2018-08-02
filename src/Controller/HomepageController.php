<?php

namespace App\Controller;

use App\Repository\GigRepository;
use App\Repository\NewsRepository;
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
    public function backendDashboard(): Response
    {
        return $this->render('Homepage/backend-dashboard.html.twig', []);
    }

    public function index(GigRepository $gigRepository, NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->findLatestNews(3);
        $gigs = $gigRepository->findNextUpcomingGigsSortedByDate(5);

        return $this->render('Homepage/index.html.twig', [
            'newsList' => $news,
            'gigs' => $gigs
        ]);
    }
}
