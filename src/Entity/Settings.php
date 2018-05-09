<?php

namespace App\Entity;

/**
 * Class Settings
 */
class Settings extends AbstractEntity
{
    const BAND_NAME = 'band_name';
    const FACEBOOK_PAGE = 'facebook_page';
    const INSTAGRAM_ACCOUNT = 'instagram_account';
    const YOUTUBE_CHANNEL = 'youtube_channel';
    const SPOTIFY_ACCOUNT = 'spotify_account';
    const FAVICON = 'favicon';

    /**
     * @var string
     */
    private $settingsKey;

    /**
     * @var string
     */
    private $settingsValue;

    /**
     * Settings constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->settingsKey = $key;
        $this->slug = $key;
    }

    /**
     * @return string
     */
    public function getSettingsKey(): string
    {
        return $this->settingsKey;
    }

    /**
     * @return string
     */
    public function getSettingsValue(): ?string
    {
        return $this->stringTransform($this->settingsValue);
    }

    /**
     * @param null|string $settingsValue
     */
    public function setSettingsValue(?string $settingsValue): void
    {
        $this->settingsValue = $settingsValue;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->stringTransform($this->settingsValue);
    }
}
