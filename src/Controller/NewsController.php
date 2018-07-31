<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\Type\NewsType;
use App\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NewsController
 */
class NewsController extends AbstractCrudController
{
    /**
     * @param NewsRepository $newsRepository
     * @param int $page
     * @return Response
     */
    public function paginated(NewsRepository $newsRepository, int $page = 1): Response
    {
        $news = array_reverse($newsRepository->findAll());
        $numberOfNews = 2;

        $entities = array_slice($news, ($page - 1) * $numberOfNews, $numberOfNews);

        return $this->render(
            sprintf('%s/list-frontend.html.twig', $this->getTemplateBasePath()),
            [
                'entities' => $entities,
                'page' => $page,
                'numberOfPages' => ceil(count($news) / $numberOfNews)
            ]
        );
    }

    /**
     * @return News
     */
    protected function createNewEntity()
    {
        return new News();
    }

    /**
     * @return string
     */
    protected function getFormType(): string
    {
        return NewsType::class;
    }

    /**
     * @return string
     */
    protected function getTemplateBasePath(): string
    {
        return 'News';
    }

    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return 'App\Entity\News';
    }

    /**
     * @return string
     */
    protected function getRoutePrefix(): string
    {
        return 'news';
    }
}
