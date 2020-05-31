<?php

namespace App\Form;

use App\Entity\Diy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de l\'activité'
                ]
            ])
            ->add('zip',NumberType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code postal'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('link', UrlType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lien de l\'activité'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Diy::class,
        ]);
    }
}
