<?php

namespace App\Controller;

use App\Repository\GigRepository;
use App\Repository\NewsRepository;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SitemapController
 */
class SitemapController extends Controller
{
    /**
     * @param GigRepository $gigRepository
     * @param NewsRepository $newsRepository
     * @param PageRepository $pageRepository
     * @return Response
     */
    public function index(
        GigRepository $gigRepository,
        NewsRepository $newsRepository,
        PageRepository $pageRepository
    ): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'xml');

        return $this->render(
            'Sitemap/sitemap.html.twig',
            [
                'gigs' => $gigRepository->findAll(),
                'newsList' => $newsRepository->findAll(),
                'pages' => $pageRepository->findAll(),
            ],
            $response
        );
    }
}
