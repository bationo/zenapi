<?php

namespace GeranceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoyerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbMois')
            ->add('montant')
            ->add('debut', 'datetime')
            ->add('fin', 'datetime')
            ->add('created', 'datetime')
            ->add('modified', 'datetime')
            ->add('contrat')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GeranceBundle\Entity\Loyer'
        ));
    }
}
