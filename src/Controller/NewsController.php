<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\Type\NewsType;

/**
 * Class NewsController
 */
class NewsController extends AbstractCrudController
{
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
