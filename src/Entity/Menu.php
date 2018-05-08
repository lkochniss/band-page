<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Menu
 */
class Menu extends AbstractEntity
{
    const MAIN_MENU = 'main_menu';
    const FOOTER_MENU = 'footer_menu';

    /**
     * @var string
     */
    private $type;

    /**
     * @var ArrayCollection
     */
    private $items;

    /**
     * Menu constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
        $this->slug = $type;
        $this->items = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items->toArray();
    }

    /**
     * @param MenuItem $menuItem
     */
    public function addItem(MenuItem $menuItem): void
    {
        if (!$this->items->contains($menuItem)) {
            $this->items->add($menuItem);
            $menuItem->setMenu($this);
        }
    }


}
