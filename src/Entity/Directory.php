<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Directory
 */
class Directory extends AbstractEntity
{
    /**
     * @var String
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var String
     */
    private $path;

    /**
     * @var String
     */
    private $fullPath;

    /**
     * @var Directory
     */
    private $parentDirectory;

    /**
     * @var ArrayCollection
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $images;

    /**
     * @var ArrayCollection;
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $childDirectories;

    /**
     * Directory constructor.
     */
    public function __construct()
    {
        $this->childDirectories = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
        $this->path = $this->slugify($name);
        $this->resetFullPath();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->stringTransform($this->name);
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
        $this->updateFullpath();
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function updateFullpath(): void
    {
        $this->resetFullPath();

        foreach ($this->childDirectories as $childDirectory) {
            $childDirectory->resetFullPath();
        }

        foreach ($this->images as $image) {
            $image->resetFullPath();
        }
    }

    public function resetFullPath(): void
    {
        if ($this->isRootNode()) {
            $this->fullPath = $this->path;
            return;
        }

        $this->fullPath = $this->parentDirectory->getFullPath() . '/' . $this->path;
    }

    /**
     * @return string
     */
    public function getFullPath(): string
    {
        return $this->fullPath;
    }

    /**
     * @param Directory|null $parentDirectory
     */
    public function setParentDirectory(?Directory $parentDirectory): void
    {
        $this->parentDirectory = $parentDirectory;
        $this->resetFullPath();
    }

    /**
     * @return Directory
     */
    public function getParentDirectory(): Directory
    {
        return $this->parentDirectory;
    }

    /**
     * @param Directory $directory
     */
    public function addChildDirectory(Directory $directory): void
    {
        if (!$this->childDirectories->contains($directory)) {
            $this->childDirectories->add($directory);
            $directory->setParentDirectory($this);
        }
    }

    /**
     * @param Directory $directory
     */
    public function removeChildDirectory(Directory $directory): void
    {
        $this->childDirectories->removeElement($directory);
    }

    /**
     * @return array
     */
    public function getChildDirectories(): array
    {
        return $this->childDirectories->toArray();
    }

    /**
     * @param Image $image
     */
    public function addImage(Image $image): void
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setParentDirectory($this);
        }
    }

    /**
     * @param Image $image
     */
    public function removeImages(Image $image): void
    {
        $this->images->removeElement($image);
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images->toArray();
    }

    /**
     * @return bool
     */
    public function isRootNode(): bool
    {
        return is_null($this->parentDirectory) ? true : false;
    }
}
