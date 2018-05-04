<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\Type\PageType;

/**
 * Class PageController
 */
class PageController extends AbstractCrudController
{
    /**
     * @return Page
     */
    protected function createNewEntity()
    {
        return new Page();
    }

    /**
     * @return string
     */
    protected function getFormType(): string
    {
        return PageType::class;
    }

    /**
     * @return string
     */
    protected function getTemplateBasePath(): string
    {
        return 'Page';
    }

    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return 'App\Entity\Page';
    }

    /**
     * @return string
     */
    protected function getRoutePrefix(): string
    {
        return 'page';
    }
}
