<?php

namespace App\Form;

use App\Entity\Information;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titre de l\'information'
                ]
            ])
            ->add('sujet', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Sujet de l\'information'
                ]
            ])
            ->add('description', TextareaType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('link', UrlType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lien de l\'information'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Information::class,
        ]);
    }
}
