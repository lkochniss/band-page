<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Page
 */
class Page extends AbstractEntity
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var ArrayCollection
     */
    private $items;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->stringTransform($this->title);
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->stringTransform($this->content);
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function setSlug(): void
    {
        $this->slug = $this->slugify($this->getTitle());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->title;
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
            $menuItem->setPage($this);
        }
    }
}
