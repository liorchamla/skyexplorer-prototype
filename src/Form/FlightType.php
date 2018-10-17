<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Flight;
use App\Entity\Plane;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightType extends AbstractType
{
    private function getConfig($label, $placeholder = '', $options = [])
    {
        return array_merge_recursive(['label' => $label, 'attr' => ['placeholder' => $placeholder]], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('flightTime', NumberType::class, $this->getConfig('Temps de vol', 'Temps de vol (en heures)', ['required' => false]))
            ->add('floorTime', NumberType::class, $this->getConfig('Temps de sol', 'Temps de sol (en heures)', ['required' => false]))
            ->add('isFlightBook', CheckboxType::class, $this->getConfig('Carnet de vol', '', ['required' => false]))
            ->add('isLPE', CheckboxType::class, $this->getConfig('LPE', '', ['required' => false]))
            ->add('paymentType', ChoiceType::class, [
                'label' => 'Mode de paiement',
                'choices' => [
                    'Aucun' => '',
                    'Visa' => 'VISA',
                    'Chèque' => 'CHQ',
                    'Virement' => 'VIREMENT',
                    'Espèces' => 'ESPECES',
                ],
            ])
            ->add('isPaid', CheckboxType::class, ['label' => 'Somme réglée ?', 'required' => false])
            ->add('escaleLocation', TextType::class, $this->getConfig('Escale', 'Ville d\'escale (si il y a eu escale)', ['required' => false]))
            ->add('startAt', TimeType::class, ['label' => 'Heure de départ'])
            ->add('endAt', TimeType::class, ['label' => 'Heure d\'arrivée'])
            ->add('day', DateType::class, ['label' => 'Date du vol', 'attr' => ['placeholder' => 'Date du vol'], 'widget' => 'single_text'])
            ->add('fuel', NumberType::class, $this->getConfig('Achat de fuel ?', 'Entrez le fuel acheté', ['required' => false]))
            ->add('plane', EntityType::class, [
                'class' => Plane::class,
                'choice_label' => 'title',
                'label' => 'Avion',
            ])
            // ->add('teacher', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => function($user) {
            //         return $user->getFirstName;
            //     }
            // ])
            ->add('student', EntityType::class, [
                'class' => User::class,
                'choice_label' => function ($user) {
                    return $user->getFirstName() . ' ' . $user->getLastName();
                },
                'label' => 'Elève',
            ])
            ->add('course', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'title',
                'label' => 'Cours',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Flight::class,
        ]);
    }
}
