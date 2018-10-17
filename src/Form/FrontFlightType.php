<?php

namespace App\Form;

use App\Entity\Flight;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FrontFlightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('flightTime')
            ->add('floorTime')
            ->add('escale')
            ->add('isFlightBook')
            ->add('isLPE')
            ->add('paymentType')
            ->add('isPaid')
            ->add('escaleLocation')
            ->add('startAt')
            ->add('endAt')
            ->add('day')
            ->add('fuel')
            ->add('plane')
            ->add('teacher')
            ->add('student')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Flight::class,
        ]);
    }
}
