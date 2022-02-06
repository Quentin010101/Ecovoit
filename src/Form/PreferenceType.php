<?php

namespace App\Form;

use App\Entity\Preference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PreferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatar', FileType::class, [
                'label' => 'Avatar',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10240000k',
                    ])
                ]
            ])
            ->add('petAllowed', ChoiceType::class, [
                'label' => 'Animaux de companie',
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0
                ],
                'expanded' => true
            ])
            ->add('smokingAllowed', ChoiceType::class, [
                'label' => 'Fumeur autorisé',
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0
                ],
                'expanded' =>true
            ])
            ->add('music', ChoiceType::class, [
                'label' => 'Musique:',
                'choices' => [
                    'Pas de musique' => 0,
                    'Oui un peu' => 1,
                    'Pendant tout le trajet!' => 2,
                ],
                'expanded' =>true
            ])
            ->add('talking', ChoiceType::class, [
                'label' => 'Discution',
                'choices' => [
                    'Ne discute pas' => 0,
                    'Discute un peu' => 1,
                    'Pendant tout le trajet!' => 2,
                ],
                'expanded' =>true
            ])
            ->add('theme', ChoiceType::class, [
                'label' => 'Theme:',
                'choices' => [
                    'Light' => 0,
                    'Dark' => 1,
                ],
                'expanded' =>true
            ])
            ->add('Modifier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Preference::class,
        ]);
    }
}
