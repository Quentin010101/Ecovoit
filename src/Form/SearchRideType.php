<?php

namespace App\Form;

use App\Entity\RoadTrip;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchRideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startingPlace', TextType::class, [
                'label' => 'Adresse de départ',
                'attr' => ['placeholder' => "D'ou voulez vous partir?"]
            ])
            ->add('endingPlace', TextType::class, [
                'label' => "Adresse d'arrivé",
                'attr' => ['placeholder' => "Ou voulez vous aller?"]
            ])
            ->add('tripDate', DateType::class, [
                'label' => 'Jour du départ',
                'data' => new DateTime('now')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RoadTrip::class,
        ]);
    }
}
