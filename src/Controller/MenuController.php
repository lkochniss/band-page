<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\Type\MenuType;
use App\Repository\MenuItemRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MenuController
 */
class MenuController extends AbstractCrudController
{
    /**
     * @return RedirectResponse|Response
     */
    public function listMainMenu()
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
     * @param Request $request
     * @param MenuItemRepository $menuItemRepository
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateMainMenu(Request $request, MenuItemRepository $menuItemRepository): JsonResponse
    {
        $changeset = $request->request->get('changeset');

        foreach (\GuzzleHttp\json_decode($changeset) as $key => $item) {
            $menuItem = $menuItemRepository->find($item);
            $menuItem->setPosition($key);
            $menuItemRepository->save($menuItem);
        }

        return new JsonResponse('ok');
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
