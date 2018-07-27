<?php

namespace App\Entity;

/**
 * Class Gig
 */
class Gig extends AbstractEntity
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var Location
     */
    private $location;

    /**
     * @var float
     */
    private $price = 0.0;

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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->stringTransform($this->description);
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description ?: '';
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->dateTimeTransform($this->date);
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->floatTransform($this->price);
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price ?: 0.0;
    }

    public function setSlug(): void
    {
        $this->slug = $this->slugify($this->getDate()->format('Y-m-d-') . $this->getTitle());
    }
}
