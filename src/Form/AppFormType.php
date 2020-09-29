<?php

namespace App\Form;

use App\Entity\App;
use App\Entity\Classification;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


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
                'windows',
                CheckboxType::class,
                [
                    'required' => false,
                    'label' => 'Windows',
                ]
            )
            ->add(
                'linux',
                CheckboxType::class,
                [
                    'required' => false,
                    'label' => 'Linux',
                ]
            )
            ->add(
                'mac',
                CheckboxType::class,
                [
                    'required' => false,
                    'label' => 'Mac',
                ]
            )
            ->add(
                'android',
                CheckboxType::class,
                [
                    'required' => false,
                    'label' => 'Android',
                ]
            )
            ->add(
                'windowsFile',
                FileType::class,
                [
                    'required' => false,
                    'multiple' => false,
                    'label' => 'Exécutable Windows',
                ]
            )
            ->add(
                'linuxFile',
                FileType::class,
                [
                    'required' => false,
                    'multiple' => false,
                    'label' => 'Exécutable Linux',
                ]
            )
            ->add(
                'macFile',
                FileType::class,
                [
                    'required' => false,
                    'multiple' => false,
                    'label' => 'Exécutable Mac',
                ]
            )
            ->add(
                'androidFile',
                FileType::class,
                [
                    'required' => false,
                    'multiple' => false,
                    'label' => 'Exécutable Android',
                ]
            )
            ->add(
                'coverFile',
                VichImageType::class,
                [
                    'required' => false,
                    'allow_delete' => true,
                    'download_uri' => true,
                    'download_label' => 'Télécharger',
                    'delete_label' => 'Supprimer',
                    'asset_helper' => true,
                ]
            )
            ->add(
                'screenshotsFile',
                FileType::class,
                [
                    'multiple' => true,
                    'required' => false,
                    'mapped' => false,
                ]
            )
            ->add(
                'classification',
                EntityType::class,
                [
                    'placeholder' => 'Choississez une classification',
                    'class' => Classification::class,
                    'choice_value' => 'getId',
                    'choice_label' => 'getFr',
                ]
            )
        ->add('isReleased');

        $builder->get('classification')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm()->getParent();
                $classification = $event->getForm()->getData();
                $this->addGenreField($form, $classification);

            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                /* @var $data App */
                $data = $event->getData();
                /* @var $classification  Classification */
                $classification = $data->getClassification();
                if ($classification) {
                    $form = $event->getForm();
                    $this->addGenreField($form, $classification);
                } else {
                    $form = $event->getForm();
                    $this->addGenreField($form, null);
                }
            }
        );
    }

    /**
     * Add a Genre field to the form
     * @param FormInterface $form
     * @param Classification $classification
     */
    private function addGenreField(FormInterface $form, ?Classification $classification)
    {


        $form->add(
            'genre',
            EntityType::class,
            [
                'placeholder' => $classification ? 'Choississez un genre' : 'Vous devez d\'abord choisir une classification',
                'class' => Genre::class,
                'choice_value' => 'getId',
                'choice_label' => 'getFr',
                'required' => true,
                'choices' => $classification ? $classification->getGenre() : [],
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
