<?php

namespace App\Form;

use App\Entity\Gaming;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GamingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titre du jeu'
                ]
            ])
            ->add('type',ChoiceType::class,[
                'label' => false,
                    'choices'  => [
                        'Discord'=> 'Discord',
                        'Skype'  => 'Skype',
                        'Autre'  => 'Autre',
                    ],
                    'multiple' => false,
                    'expanded' => false,
                    'choice_label' => function ($choice, $key, $value) {
                if (true === $choice) {
                    return 'Definitely!';
                }
                    return strtoupper($key);
                    // or if you want to translate some key
                    //return 'form.choice.'.$key;
                }
            ])
            ->add('link',UrlType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lien du jeu'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gaming::class,
        ]);
    }
}
