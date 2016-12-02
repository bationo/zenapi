<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ProfilEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom' , TextType::class, array("disabled" =>true)  )
            ->add('tel' )
            ->add('prenom' , TextType::class, array("disabled" =>true) )
            ->add('dateNaissance' , DateType::class , array(
			'years' => range(1916, 2016),
			"disabled" =>true
			
			) )
            ->add('lieuNaissance' , TextType::class, array("disabled" =>true) )
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
			->add('commenatire' , TextareaType::class , array( "mapped" => false )  )
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
