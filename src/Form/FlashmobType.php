<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlashmobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('type',HiddenType::class,[
                'data' => 'FLASHMOB',
                'attr' => [
                    'class' => 'hidden'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('support',ChoiceType::class,[
                'label' => false,
                'choices'  => [
                    'choisir' => [
                        'Youtube'=> 'Youtube',
                        'facebook'  => 'facebook',
                        'Autre'  => 'Autre'
                    ]
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
                    'placeholder' => 'Lien de la vidéo'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
