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
    public function listUpcoming(): Response
    {
        return $this->render(
            sprintf('%s/list-upcoming.html.twig', $this->getTemplateBasePath()),
            [
                'entities' => $this->getDoctrine()->getRepository($this->getEntityName())
                    ->findAllUpcomingGigsSortedByDate()
            ]
        );
    }

    /**
     * @return Response
     */
    public function listPast(): Response
    {
        return $this->render(
            sprintf('%s/list-past.html.twig', $this->getTemplateBasePath()),
            [
                'entities' => $this->getDoctrine()->getRepository($this->getEntityName())
                    ->findAllPastGigsSortedByDate()
            ]
        );
    }

    /**
     * @return Response
     */
    public function listOldGigs(): Response
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
