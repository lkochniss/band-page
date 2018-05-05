<?php

namespace App\Entity;

/**
 * Class Location
 */
class Location extends AbstractEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $city;

    /**
     * @var int
     */
    private $zip = 0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->stringTransform($this->name);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->stringTransform($this->street);
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->stringTransform($this->city);
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return int
     */
    public function getZip(): int
    {
        return $this->integerTransform($this->zip);
    }

    /**
     * @param int $zip
     */
    public function setZip(int $zip): void
    {
        $this->zip = $zip;
    }

    public function setSlug(): void
    {
        $this->slug = $this->slugify($this->getCity(). $this->getName());
    }
}
