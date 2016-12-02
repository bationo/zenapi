<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfessionnelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('tel')
            ->add('ville')
            ->add('dure')
            ->add('ouverture')
            ->add('fermeture')
            ->add('presentation')
            ->add('tarif')
            ->add('localisation')
            ->add('url')
            ->add('langue')
			->add('fixe')
			
			->add('jour' , ChoiceType::class, array(
			'choices'  => array(
				'Jour de Travail' => "",
				'DU LUNDI AU VENDREDI' => 'DU LUNDI AU VENDREDI',
				'DU LUNDI AU SAMEDI' => 'DU LUNDI AU SAMEDI',
				'DU LUNDI AU DIMANCHE' => 'DU LUNDI AU DIMANCHE',
			), 
			))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Professionnel'
        ));
    }
}
