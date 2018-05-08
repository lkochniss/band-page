<?php

namespace App\Controller;

use App\Entity\AbstractEntity;
use App\Entity\MenuItem;
use App\Form\Type\MenuItemType;
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

        return $this->createAndHandleForm($menuItem, $request, 'item_create', ['menuId' => $menuId]);
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
            'item_edit',
            [
                'menuId' => $menuId,
                'itemId' => $itemId
            ]
        );
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

                return $this->redirect($this->generateUrlForAction('main_list'));
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
        return 'menu';
    }
}
