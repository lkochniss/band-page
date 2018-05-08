<?php

namespace App\Controller;

use App\Entity\AbstractEntity;
use App\Entity\Menu;
use App\Entity\MenuItem;
use App\Form\Type\MenuItemType;
use App\Repository\MenuItemRepository;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MenuItemController
 */
class MenuItemController extends AbstractCrudController
{
    public function createItemForMenu(int $menuId, MenuRepository $menuRepository, Request $request)
    {
        $menu = $menuRepository->find($menuId);

        if (is_null($menu)) {
            throw new NotFoundHttpException();
        }

        $menuItem = $this->createNewEntity();
        $menuItem->setMenu($menu);
        $menuItem->setPosition(count($menu->getItems()));

        return $this->createAndHandleForm($menuItem, $request, 'create', ['menuId' => $menuId]);
    }

    public function editItemForMenu(int $menuId, int $itemId, MenuRepository $menuRepository, Request $request)
    {
        $menu = $menuRepository->findOneBy(['id' => $menuId]);

        if (is_null($menu)) {
            throw new NotFoundHttpException();
        }

        $menuItem = $this->getDoctrine()->getRepository($this->getEntityName())->find($itemId);

        return $this->createAndHandleForm(
            $menuItem,
            $request,
            'edit',
            [
                'menuId' => $menuId,
                'itemId' => $itemId
            ]
        );
    }

    /**
     * @param int $menuId
     * @param int $itemId
     * @param MenuRepository $menuRepository
     * @param MenuItemRepository $menuItemRepository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeItem(int $menuId, int $itemId, MenuRepository $menuRepository, MenuItemRepository $menuItemRepository): Response
    {
        $menu = $menuRepository->findOneBy(['id' => $menuId]);

        if (is_null($menu)) {
            throw new NotFoundHttpException();
        }

        $menuItem = $this->getDoctrine()->getRepository($this->getEntityName())->find($itemId);
        $menuItemRepository->remove($menuItem);

        $route = $menu->getType() === Menu::MAIN_MENU ? 'menu_main_list' : 'menu_footer_list';

        return $this->redirect($this->generateUrl($route));
    }

    /**
     * @param AbstractEntity $entity
     * @param Request $request
     * @param $action
     * @param array $options
     * @return RedirectResponse|Response
     */
    protected function createAndHandleForm(AbstractEntity $entity, Request $request, $action, array $options = [])
    {
        $form = $this->createForm(
            $this->getFormType(),
            $entity,
            [
                'action' => $this->generateUrlForAction($action, $options),
                'method' => 'POST',
            ]
        );

        if (in_array($request->getMethod(), ['POST'])) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->handleValidForm($entity);

                $route = $entity->getMenu()->getType() === Menu::MAIN_MENU ? 'menu_main_list' : 'menu_footer_list';

                return $this->redirect($this->generateUrl($route));
            }
        }

        return $this->render(
            sprintf('%s/edit.html.twig', $this->getTemplateBasePath()),
            [
                'entity' => $entity,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @return MenuItem
     */
    protected function createNewEntity()
    {
        return new MenuItem();
    }

    /**
     * @return string
     */
    protected function getFormType(): string
    {
        return MenuItemType::class;
    }

    /**
     * @return string
     */
    protected function getTemplateBasePath(): string
    {
        return 'MenuItem';
    }

    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return 'App\Entity\MenuItem';
    }

    /**
     * @return string
     */
    protected function getRoutePrefix(): string
    {
        return 'menu_item';
    }
}
