<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\Type\LocationType;

/**
 * Class LocationController
 */
class LocationController extends AbstractCrudController
{
    /**
     * @return \App\Entity\AbstractEntity|Location
     */
    protected function createNewEntity()
    {
        return new Location();
    }

    /**
     * @return string
     */
    protected function getFormType(): string
    {
        return LocationType::class;
    }

    /**
     * @return string
     */
    protected function getTemplateBasePath(): string
    {
        return 'Location';
    }

    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return 'App\Entity\Location';
    }

    /**
     * @return string
     */
    protected function getRoutePrefix(): string
    {
        return 'location';
    }
}
