<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email'
                ]
            ])
            ->add('nom', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('prenom',TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom'
                ]
            ])
            ->add('avatarFile', FileType::class,[
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Photo du profil'
                ]
            ])
            ->add('description', TextareaType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            //->add('localisation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
