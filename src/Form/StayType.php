<?php

namespace App\Form;

use App\Entity\Doctor;
use App\Entity\Specialty;
use App\Entity\Stay;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'arrivée',
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
            ])
            ->add('reason', TextType::class, [
                'label' => 'Motif',
            ])
            ->add('specialty', EntityType::class, [
                'class' => Specialty::class,
                'choice_label' => 'name',
                'label' => 'Spécialité',
                'placeholder' => 'Choisissez une spécialité',
            ])
            ->add('doctor', EntityType::class, [
                'class' => Doctor::class,
                'choice_label' => function(Doctor $doctor) {
                    return $doctor->getFirstname() . ' ' . $doctor->getLastname();
                },
                'label' => 'Docteur',
                'placeholder' => 'Choisissez un docteur',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stay::class,
        ]);
    }
}

