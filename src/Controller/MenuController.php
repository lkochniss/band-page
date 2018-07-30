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
        return $this->listMenu(Menu::MAIN_MENU);
    }

    /**
     * @return RedirectResponse|Response
     */
    public function listFooterMenu(): Response
    {
        return $this->listMenu(Menu::FOOTER_MENU);
    }

    /**
     * @param Request $request
     * @param MenuItemRepository $menuItemRepository
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateMenu(Request $request, MenuItemRepository $menuItemRepository): JsonResponse
    {
        $changeset = $request->request->get('changeset');

        foreach (\GuzzleHttp\json_decode($changeset) as $key => $item) {
            $menuItem = $menuItemRepository->find($item);
            $menuItem->setPosition($key);
            $menuItemRepository->save($menuItem, $this->getUser());
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

    /**
     * @param string $menuType
     * @return Response
     */
    private function listMenu(string $menuType): Response
    {
        $menu = $this->getDoctrine()->getRepository($this->getEntityName())->findOneByTypeOrCreate($menuType);

        return $this->render(
            sprintf('%s/edit.html.twig', $this->getTemplateBasePath()),
            [
                'menu' => $menu
            ]
        );
    }
}
