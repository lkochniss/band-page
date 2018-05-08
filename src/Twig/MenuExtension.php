<?php

namespace App\Twig;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MenuExtension extends AbstractExtension
{
    /**
     * @var MenuRepository
     */
    private $menuRepository;

    /**
     * MenuExtension constructor.
     * @param MenuRepository $menuRepository
     */
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('getMainMenu', [$this, 'getMainMenu']),
            new TwigFilter('getFooterMenu', [$this, 'getFooterMenu']),
        ];
    }

    /**
     * @return Menu
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getMainMenu(): Menu
    {
        return $this->menuRepository->findOneByTypeOrCreate(Menu::MAIN_MENU);
    }

    /**
     * @return Menu
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getFooterMenu(): Menu
    {
        return $this->menuRepository->findOneByTypeOrCreate(Menu::FOOTER_MENU);
    }
}
