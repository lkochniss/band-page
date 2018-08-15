<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Form\Type\GeneralSettingsType;
use App\Form\Type\SeoSettingsType;
use App\Form\Type\SocialSettingsType;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SettingsController
 */
class SettingsController extends Controller
{
    /**
     * @param Request $request
     * @param SettingsRepository $settingsRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function general(Request $request, SettingsRepository $settingsRepository)
    {
        $settings = [
            'bandName' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::BAND_NAME),
            'favicon' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::FAVICON),
            'linkToShop' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::LINK_TO_SHOP),
            'bannerImage' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::BANNER_IMAGE),
            'backgroundImage' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::BACKGROUND_IMAGE),
        ];

        $form = $this->createForm(
            GeneralSettingsType::class,
            $settings,
            [
                'action' => $this->generateUrl('settings_general'),
                'method' => 'POST',
            ]
        );

        if (in_array($request->getMethod(), ['POST'])) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                foreach ($form->getData() as $key => $value) {
                    $setting = $settings[$key];
                    $setting->setSettingsValue($value);
                    $settingsRepository->save($setting, $this->getUser());
                }
            }
        }

        return $this->render(
            'Settings/general.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param SettingsRepository $settingsRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function social(Request $request, SettingsRepository $settingsRepository)
    {
        $settings = [
            'facebookPage' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::FACEBOOK_PAGE),
            'facebookIframe' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::FACEBOOK_IFRAME),
            'instagramAccount' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::INSTAGRAM_ACCOUNT),
            'instagramIframe' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::INSTAGRAM_IFRAME),
            'youtubeChannel' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::YOUTUBE_CHANNEL),
            'spotifyAccount' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::SPOTIFY_ACCOUNT),
            'spotifyIframe' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::SPOTIFY_IFRAME),
        ];

        $form = $this->createForm(
            SocialSettingsType::class,
            $settings,
            [
                'action' => $this->generateUrl('settings_social'),
                'method' => 'POST',
            ]
        );

        if (in_array($request->getMethod(), ['POST'])) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                foreach ($form->getData() as $key => $value) {
                    $setting = $settings[$key];
                    $setting->setSettingsValue($value);
                    $settingsRepository->save($setting, $this->getUser());
                }
            }
        }

        return $this->render(
            'Settings/social.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param SettingsRepository $settingsRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function seo(Request $request, SettingsRepository $settingsRepository)
    {
        $settings = [
            'metaDescription' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::META_DESCRIPTION),
            'metaImage' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::META_IMAGE),
        ];

        $form = $this->createForm(
            SeoSettingsType::class,
            $settings,
            [
                'action' => $this->generateUrl('settings_seo'),
                'method' => 'POST',
            ]
        );

        if (in_array($request->getMethod(), ['POST'])) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                foreach ($form->getData() as $key => $value) {
                    $setting = $settings[$key];
                    $setting->setSettingsValue($value);
                    $settingsRepository->save($setting, $this->getUser());
                }
            }
        }

        return $this->render(
            'Settings/seo.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
