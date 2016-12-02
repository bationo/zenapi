<?php

namespace GeranceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('etat')
            ->add('dateSignature', 'date')
            ->add('dateDebut', 'date')
            ->add('dateFin', 'date')
            ->add('created', 'datetime')
            ->add('modified', 'datetime')
            ->add('validite', 'datetime')
            ->add('limite')
            ->add('locative')
            ->add('locataire')
            ->add('contrat')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GeranceBundle\Entity\Contrat'
        ));
    }
}
