<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Form\Type\SettingsType;
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
    public function edit(Request $request, SettingsRepository $settingsRepository)
    {
        $settings = [
            'bandName' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::BAND_NAME),
            'facebookPage' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::FACEBOOK_PAGE),
            'instagramAccount' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::INSTAGRAM_ACCOUNT),
            'youtubeChannel' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::YOUTUBE_CHANNEL),
            'spotifyAccount' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::SPOTIFY_ACCOUNT),
            'favicon' => $bandName = $settingsRepository->findOneByKeyOrCreate(Settings::FAVICON),
        ];

        $form = $this->createForm(
            SettingsType::class,
            $settings,
            [
                'action' => $this->generateUrl('settings_edit'),
                'method' => 'POST',
            ]
        );

        if (in_array($request->getMethod(), ['POST'])) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                foreach ($form->getData() as $key => $value) {
                    $setting = $settings[$key];
                    $setting->setSettingsValue($value);
                    $settingsRepository->save($setting);
                }
            }
        }

        return $this->render(
            'Settings/edit.html.twig',
            [
                'settings' => $bandName,
                'form' => $form->createView(),
            ]
        );
    }
}
