<?php

namespace App\Form;

use App\Entity\Discuter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscuterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Identifiant'
                ]
            ])
            ->add('sujet', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Sujet de la discution'
                ]
            ])
            ->add('link',TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lien de la discution',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Discuter::class,
        ]);
    }
}
