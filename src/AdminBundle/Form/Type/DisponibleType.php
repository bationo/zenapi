<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisponibleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creno' )
            ->add('heure' )
            ->add('heureFin' )
			->add('jour', EntityType::class , array(

							  'class'    => 'AdminBundle:Jour',

							  'choice_label' => 'libele',

							  'multiple' => false,

							  'required' => true,


							) )
			->add('domicile', ChoiceType::class, array(
			'choices'  => array(
				
				'NON' => false,
				'OUI' => true,
			)))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Disponible'
        ));
    }
}
