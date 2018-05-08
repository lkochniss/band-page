<?php

namespace App\Entity;

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

    public function getName(): string
    {
        return $this->title;
    }
}
