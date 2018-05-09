<?php

namespace App\Twig;

use App\Entity\Settings;
use App\Repository\SettingsRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SettingsExtension extends AbstractExtension
{
    /**
     * @var SettingsRepository
     */
    private $settingsRepository;

    /**
     * SettingsExtension constructor.
     * @param SettingsRepository $settingsRepository
     */
    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('getBandName', [$this, 'getBandName']),
            new TwigFilter('getFacebookPage', [$this, 'getFacebookPage']),
            new TwigFilter('getInstagramAccount', [$this, 'getInstagramAccount']),
            new TwigFilter('getYouTubeChannel', [$this, 'getYouTubeChannel']),
            new TwigFilter('getSpotifyAccount', [$this, 'getSpotifyAccount']),
            new TwigFilter('getFavicon', [$this, 'getFavicon']),
        ];
    }

    /**
     * @return string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getBandName(): string
    {
        $bandName = $this->settingsRepository->findOneByKeyOrCreate(Settings::BAND_NAME);

        return $bandName->getSettingsValue() ?: 'band-page';
    }

    /**
     * @return string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getFacebookPage(): ?string
    {
        $bandName = $this->settingsRepository->findOneByKeyOrCreate(Settings::FACEBOOK_PAGE);

        return $bandName->getSettingsValue() ?: null;
    }

    /**
     * @return string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getInstagramAccount(): ?string
    {
        $bandName = $this->settingsRepository->findOneByKeyOrCreate(Settings::INSTAGRAM_ACCOUNT);

        return $bandName->getSettingsValue() ?: null;
    }

    /**
     * @return string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getYouTubeChannel(): ?string
    {
        $bandName = $this->settingsRepository->findOneByKeyOrCreate(Settings::YOUTUBE_CHANNEL);

        return $bandName->getSettingsValue() ?: null;
    }

    /**
     * @return string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getSpotifyAccount(): ?string
    {
        $bandName = $this->settingsRepository->findOneByKeyOrCreate(Settings::SPOTIFY_ACCOUNT);

        return $bandName->getSettingsValue() ?: null;
    }

    /**
     * @return string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getFavicon(): ?string
    {
        $bandName = $this->settingsRepository->findOneByKeyOrCreate(Settings::FAVICON);

        return $bandName->getSettingsValue() ?: null;
    }
}
