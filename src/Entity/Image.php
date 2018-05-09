<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Image
 */
class Image extends AbstractEntity
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
     * @var UploadedFile
     *
     * @Assert\NotBlank()
     * @Assert\File(
     *     mimeTypes = {"image/jpeg", "image/png", "image/gif"},
     * )
     */
    private $file;

    /**
     * @param $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->stringTransform($this->name);
    }

    /**
     * @param $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
        $this->resetFullPath();
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return Directory
     */
    public function getParentDirectory(): Directory
    {
        return $this->parentDirectory;
    }

    /**
     * @return string
     */
    public function getFullPath(): string
    {
        return $this->fullPath;
    }

    public function resetFullPath(): void
    {
        $this->fullPath = $this->path;

        if (!is_null($this->parentDirectory)) {
            $this->fullPath = $this->parentDirectory->getFullPath() . '/' . $this->path;
        }
    }

    /**
     * @param Directory $parentDirectory
     */
    public function setParentDirectory(Directory $parentDirectory): void
    {
        $this->parentDirectory = $parentDirectory;
    }

    /**
     * @param null|UploadedFile $file
     */
    public function setFile(?UploadedFile $file): void
    {
        $this->file = $file;
    }

    /**
     * @return null|UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getAbsolutePath(): string
    {
        return '/' . $this->getFullPath();
    }

    public function upload(): void
    {
        if (null === $this->getFile()) {
            return;
        }

        $this->setPath(sprintf(
            '%s%s.%s',
            $this->path,
            $this->generateUniqueFileName(),
            $this->getFile()->guessExtension()
        ));

        $this->getFile()->move(
            $this->parentDirectory->getFullPath(),
            $this->path
        );

        $this->file = null;
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
