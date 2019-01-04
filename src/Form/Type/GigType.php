<?php

namespace App\Form\Type;

use App\Entity\Gig;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GigType
 */
class GigType extends AbstractType
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
                'title',
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
                'description',
                TextareaType::class,
                [
                    'required' => true,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'price',
                MoneyType::class,
                [
                    'required' => false,
                    'currency' => getenv('DEFAULT_CURRENCY'),
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'priceTba',
                CheckboxType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'date',
                DateTimeType::class,
                [
                    'required' => true,
                    'date_widget' => 'single_text',
                    'time_widget' => 'single_text',
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add(
                'location',
                EntityType::class,
                [
                    'required' => true,
                    'class' => 'App\Entity\Location',
                    'choice_label' => 'name',
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
            'data_class' => Gig::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'gig'
        ]);
    }
}
