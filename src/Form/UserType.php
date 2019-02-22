<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of UserType
 *
 * @author linux
 */
class UserType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', TextType::class,[
                    'required'=>'required',
                    'attr'=>[
                        'class'=>'form-username form-control',
                        'placeholder'=>'Username'
                    ]
                ])
                ->add('email', EmailType::class,[
                    'required'=>'required',
                    'attr'=>[
                        'class'=>'form-email form-control',
                        'placeholder'=>'Email'
                    ]
                ])
                ->add('plainpassword', RepeatedType::class,[
                    'type'=> PasswordType::class,
                    'required'=>'required',
                    'first_options'=>[
                        'attr'=>[
                            'class'=>'form-passwd form-control',
                            'placeholder'=>'Password'
                        ]
                    ],
                    'second_options'=>[
                        'attr'=>[
                            'class'=>'form-passwd form-control',
                            'placeholder'=>'Repeat password'
                        ]
                    ]
                ]);
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['data_class'=>User::class]);
    }
}
