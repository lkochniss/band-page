<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SocialSettingsType
 */
class SocialSettingsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @SuppressWarnings("unused")
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'facebookPage',
                UrlType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'facebookIframe',
                TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'instagramAccount',
                UrlType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'instagramIframe',
                TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'youtubeChannel',
                UrlType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'spotifyAccount',
                UrlType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'spotifyIframe',
                TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-primary form-control'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'social_settings'
        ]);
    }
}
