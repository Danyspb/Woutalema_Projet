<?php

namespace App\Form;

use App\Entity\Zone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('region',ChoiceType::class,[
                'choices'=>[
                    ''=>'',
                    'DAKAR'=>'DAKAR',
                    'THIES'=>'THIES',
                    'SAINT-LOUIS'=>'SAINT-LOUIS',
                    'ZIGUINCHOR'=>'ZIGUINCHOR',
                    'MATAM'=>'MATAM',
                    'KOLDA'=>'KOLDA',
                    'FATICK'=>'FATICK',
                    'KAFFRINE'=>'KAFFRINE',
                    'KAOLACK'=>'KAOLACK',
                    'LOUGA'=>'LOUGA',
                    'SEDHIOU' =>'SEDHIOU',
                    'TAMBACOUNDA' =>'TAMBACOUNDA',
                    'DIOURBEL'=>'DIOURBEL',
                    'KEDOUGOU' =>'KEDOUGOU',
                ]
            ])
            ->add('commune')
            ->add('horraire_debut',TimeType::class,[
                'widget' => 'single_text',
                'label' =>'Disponible de :'
            ])
            ->add('horraire_fin',TimeType::class,[
                'widget' => 'single_text',
                'label' => 'Jusqu\'a'
            ])
            ->add('contact')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Zone::class,
        ]);
    }
}
