<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Identifiant skype'
                ]
            ])
            ->add('link', UrlType::class,[
                'label' => false,
                'attr' => [
                        'placeholder' => 'Lien du cours'
                ]
            ])
            ->add('matiere', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Matière a enseigner'
                ]
            ])
            ->add('description', TextareaType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
