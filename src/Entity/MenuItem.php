<?php

namespace App\Entity;

/**
 * Class MenuItem
 */
class MenuItem extends AbstractEntity
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var Page
     */
    private $page;

    /**
     * @var Menu
     */
    private $menu;

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return Page|null
     */
    public function getPage(): ?Page
    {
        return $this->page;
    }

    /**
     * @param Page $page
     */
    public function setPage(Page $page): void
    {
        $this->page = $page;
    }

    /**
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }

    /**
     * @param Menu $menu
     */
    public function setMenu(Menu $menu): void
    {
        $this->menu = $menu;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->page->getName();
    }
}
