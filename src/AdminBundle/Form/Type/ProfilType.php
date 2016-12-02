<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ProfilType extends AbstractType
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
            ->add('prenom')
            ->add('dateNaissance' , DateType::class , array(
			'years' => range(1916, 2016)
			
			) )
            ->add('lieuNaissance')
            ->add('ville')
            ->add('groupeSanguin')
            ->add('assurer' , ChoiceType::class, array(
			'choices'  => array(
				'Etes vous assurée' => "",
				'OUI' => 1,
				'NON' => 0,
			), 
			))
            ->add('compagnieAssurance')
            ->add('numeroAssurance')
            ->add('note')
			->add('genre', ChoiceType::class, array(
					'choices' => 
					array(
					
					'Madame' => 'Madame',
					'Mademoiselle' => 'Mademoiselle',
					'Monsieur' => 'Monsieur',
					)
					
					))
            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Profil'
        ));
    }
}
