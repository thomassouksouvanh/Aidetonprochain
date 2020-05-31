<?php

namespace App\Form;

use App\Entity\Proposition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville'
                ]
            ])
            ->add('zip', NumberType::class,[
                'label' => false,
                'required'=>false,
                'attr' => [
                    'placeholder' => 'Code Postal',
                ]
            ])
            ->add('pays',TextType::class,[
                'label' => false,
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
