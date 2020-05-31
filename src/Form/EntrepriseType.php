<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de l\'entreprise partenaire'
                ]
            ])
            ->add('description', TextareaType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('city',TextType::class,[
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Ville']
            ])
            ->add('zip',NumberType::class,[
                'label' => false,
                'attr' => [
                    'placeholder'=> 'Code Postal'
                ]
            ])
            ->add('pays', TextType::class,[
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Pays']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
