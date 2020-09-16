<?php

namespace App\Form;

use App\Entity\App;
use App\Entity\Classification;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;


class AppFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('developer')
            ->add('short_description')
            ->add('description')
            ->add(
                'cover',
                FileType::class,
                [
                    'constraints' => [
                        new Image(['maxSize' => '2048k']),
                    ],
                ]
            )
            ->add(
                'classification',
                EntityType::class,
                [
                    'class' => Classification::class,
                    'choice_value' => 'getTag',
                    'choice_label' => 'getFr',
                ]
            )
            ->add(
                'genre',
                EntityType::class,
                [
                    'class' => Genre::class,
                    'choice_label' => 'getFr',
                    'choice_value' => 'getTag',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => App::class,
            ]
        );
    }
}
