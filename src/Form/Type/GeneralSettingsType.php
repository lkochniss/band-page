<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GeneralSettingsType
 */
class GeneralSettingsType extends AbstractType
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
                'bandName',
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
                'favicon',
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
                'linkToShop',
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
                'bannerImage',
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
                'backgroundImage',
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
            'csrf_token_id' => 'general_settings'
        ]);
    }
}
