<?php

namespace App\Form;

use DateTime;
use App\Entity\RoadTrip;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PostRideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startingPlace', TextType::class, [
                'label' => "D'ou voulez vous partir?",
                'attr' => ['placeholder' => "Entrer une adresse de départ",
                            'autocomplete' => 'off'],
            ])
            ->add('endingPlace', TextType::class, [
                'label' => "D'ou voulez vous aller?",
                'attr' => ['placeholder' => "Entrer une adresse d'arrivée",
                            'autocomplete' => 'off']
            ])    
            ->add('tripDistance', HiddenType::class)
            ->add('tripDuration', HiddenType::class)
            ->add('startingTime', TimeType::class, [
                'label' => "A quel heure voulez vous partir?",
                'attr' => ['placeholder' => 'Entrer une heure de départ']
            ])
            ->add('endingTime', HiddenType::class)
            ->add('numberSeat', NumberType::class, [
                'label' => "Entrer le nombre de place disponible.",
                'attr' => ['placeholder' => "Entrer le nombre de place disponible."]
            ])
            ->add('tripDate', DateType::class, [
                'label' => "Quel jour voulez vous partir?",
                'data' => new DateTime('now')
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RoadTrip::class,
        ]);
    }
}
