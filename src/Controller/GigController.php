<?php

namespace App\Controller;

use App\Entity\Gig;
use App\Form\Type\GigType;

/**
 * Class GigController
 */
class GigController extends AbstractCrudController
{
    /**
     * @return \App\Entity\AbstractEntity|Gig
     */
    protected function createNewEntity()
    {
        return new Gig();
    }

    /**
     * @return string
     */
    protected function getFormType(): string
    {
        return GigType::class;
    }

    /**
     * @return string
     */
    protected function getTemplateBasePath(): string
    {
        return 'Gig';
    }

    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return 'App\Entity\Gig';
    }

    /**
     * @return string
     */
    protected function getRoutePrefix(): string
    {
        return 'gig';
    }
}
