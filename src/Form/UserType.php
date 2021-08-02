<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,[
                'label' =>'Login'
            ])
            ->add('roles', CollectionType::class,[
                'entry_type' => ChoiceType::class,
                'entry_options' =>[
                    'label' => false,
                    'choices' =>[
                        ''=>'',
                        'Client' => 'ROLE_CLIENT',
                        'Prestataire' =>'ROLE_PRESTATAIRE',
                        'Livreur' =>'ROLE_LIVREUR'
                    ]
                ]
            ])
            ->add('password',PasswordType::class)
            ->add('nom')
            ->add('prenom')
            ->add('date_naissance', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('telephone')
            ->add('email', EmailType::class)
            ->add('numero_cni')
            ->add('adresse')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
