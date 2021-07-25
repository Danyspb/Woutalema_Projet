<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('roles', CollectionType::class,[
                'entry_type' => ChoiceType::class,
                'entry_options' =>[
                    'label' => false,
                    'choices' =>[
                        'Admin'=>'ROLE_ADMIN',
                        'Client' => 'ROLE_CLIENT',
                        'Prestataire' =>'ROLE_PRESTATAIRE',
                        'Livreur' =>'ROLE_LIVREUR'
                    ]
                ]
            ])
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('date_naissance')
            ->add('telephone')
            ->add('email')
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
