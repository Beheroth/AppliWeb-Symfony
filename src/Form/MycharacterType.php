<?php

namespace App\Form;

use App\Entity\Mycharacter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MycharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('Health')
            ->add('maxHealth')
            ->add('STR')
            ->add('WIS')
            ->add('DEX')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mycharacter::class,
        ]);
    }
}
