<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialiteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('prix')
			 ->add('libele', EntityType::class , array(

							  'class'    => 'AdminBundle:ListeSpecialite',

							  'choice_label' => 'libele',

							  'multiple' => false,

							  'required' => true,


							) )
           
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Specialite',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'specialite';
    }
}
