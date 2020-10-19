<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class UserSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
//            ->add(
//                'avatarFile',
//                FileType::class,
//                [
//                    'required' => false,
//                    'constraints' => [
//                        new Image(['maxSize' => '2048k']),
//                    ],
//                ]
//            )
            ->add('username')
            ->add('displayName')
            ->add('website')
            ->add('gender');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
