<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CommentType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('rating', NumberType::class,
                [
                    'label'=> 'Note sur 5',
                    'attr' => [
                        'min'=> 0,
                        'max'=> 5,
                        'step'=> 1,
                    ]])
            ->add('content', TextareaType::class,
                [
                    'label'=>'Commentaire',
                    'required'=> false,
                    'attr' => [
                        'placeholder' => 'Donnez votre avis'
                    ]
                ]);

/*            ->add('author', HiddenType::class,[
                'data' =>  $this,
                'attr' => [
                    'class' => 'hidden'
                ]
            ])
        ;
        $this->security->getUser();*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }

}
