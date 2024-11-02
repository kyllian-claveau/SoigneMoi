<?php

namespace App\Form;

use App\Entity\Specialty;
use App\Entity\Stay;
use App\Entity\User;
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
                'html5' => false,
                'label' => 'Date d\'arrivée',
                'format' => 'dd-MM-yyyy'
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'Date de fin',
                'format' => 'dd-MM-yyyy'
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
                'class' => User::class,
                'choice_label' => function(User $doctor) {
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
