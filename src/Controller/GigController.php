<?php

namespace App\Controller;

use App\Entity\Gig;
use App\Form\Type\GigType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GigController
 */
class GigController extends AbstractCrudController
{
    /**
     * @return Response
     */
    public function listFrontend(): Response
    {
        $entities = $this->getDoctrine()->getRepository($this->getEntityName())->findAllActiveGigsSortedByDate();

        return $this->render(
            sprintf('%s/list-frontend.html.twig', $this->getTemplateBasePath()),
            [
                'entities' => array_reverse($entities),
            ]
        );
    }

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
