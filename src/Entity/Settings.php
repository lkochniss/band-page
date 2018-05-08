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
     * @param string $settingsValue
     */
    public function setSettingsValue(string $settingsValue): void
    {
        $this->settingsValue = $settingsValue;
    }

    public function setSlug():void
    {
        $this->slug = $this->settingsKey;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->stringTransform($this->settingsValue);
    }
}
