<?php

namespace App\Entity;

/**
 * Class News
 */
class News extends AbstractEntity
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
     * @return null|String
     */
    public function getContent()
    {
        return $this->stringTransform($this->content);
    }

    /**
     * @param null|string $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content?: '';
    }

    public function setSlug(): void
    {
        $this->slug = $this->slugify($this->getCreatedAt()->format('Y-m-d-') . $this->getTitle());
    }
}
