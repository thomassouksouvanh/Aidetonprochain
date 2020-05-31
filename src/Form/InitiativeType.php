<?php

namespace App\Form;

use App\Entity\Initiative;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InitiativeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de l\'initiative'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('link',UrlType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lien de l\'initiative'
                ]
            ])
            ->add('city',TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de la ville'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Initiative::class,
        ]);
    }
}
