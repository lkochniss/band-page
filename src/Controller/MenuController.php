<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\Type\MenuType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MenuController
 */
class MenuController extends AbstractCrudController
{
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editMainMenu(Request $request)
    {
        $menu = $this->getDoctrine()->getRepository($this->getEntityName())->findOneByTypeOrCreate(Menu::MAIN_MENU);

        return $this->render(
            sprintf('%s/edit.html.twig', $this->getTemplateBasePath()),
            [
                'menu' => $menu
            ]
        );
    }

    /**
     * @return Menu
     */
    protected function createNewEntity()
    {
        return new Menu('');
    }

    /**
     * @return string
     */
    protected function getFormType(): string
    {
        return MenuType::class;
    }

    /**
     * @return string
     */
    protected function getTemplateBasePath(): string
    {
        return 'Menu';
    }

    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return 'App\Entity\Menu';
    }

    /**
     * @return string
     */
    protected function getRoutePrefix(): string
    {
        return 'menu';
    }
}
