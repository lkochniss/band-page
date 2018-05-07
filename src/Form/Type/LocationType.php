<?php

namespace App\Form\Type;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LocationType
 */
class LocationType extends AbstractType
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
                'name',
                TextType::class,
                [
                    'required' => true,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'street',
                TextType::class,
                [
                    'required' => true,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'city',
                TextType::class,
                [
                    'required' => true,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'zip',
                NumberType::class,
                [
                    'required' => true,
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
                        'class' => 'btn btn-primary form-controll'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'location'
        ]);
    }
}
