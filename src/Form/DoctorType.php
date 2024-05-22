<?php

namespace App\Form;

use App\Entity\Schedule;
use App\Entity\Specialty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DoctorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('specialty', EntityType::class, [
                'label' => 'Spécialité',
                'class' => Specialty::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une spécialité',
            ])
            ->add('matricule', TextType::class, [
                'label' => 'Matricule',
            ])
            ->add('schedules', EntityType::class, [
                'class' => Schedule::class,
                'label' => 'Emploi du temps',
                'choice_label' => 'date',
                'multiple' => true,
                'expanded' => true,
            ]);
    }
}

