<?php

namespace App\Form;

use App\Entity\Proposition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropositionShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom de la proposition'
                ]
            ])
            ->add('type', HiddenType::class,[
                'data' => 'Proposition aller faire des courses',
                'attr' => [
                    'class' => 'hidden'
                ]
            ])
            ->add('description', TextareaType::class,[
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('city',TextType::class,[
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ville'
                ]
            ])
            ->add('zip',NumberType::class,[
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Code Postal'
                ]
            ])
            ->add('pays', TextType::class,[
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Pays'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proposition::class,
        ]);
    }
}
