<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'required'=>'required',
                'attr'=>[
                    'class'=>'form-title form-control',
                    'placeholder'=>'Title'
                ]
            ])
            ->add('contenido', TextType::class,[
                'required'=>'required',
                'attr'=>[
                    'class'=>'form-content form-control',
                    'placeholder'=>'Content'
                ]
            ])
            ->add('tags')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Post::class,
        ]);
    }
}
