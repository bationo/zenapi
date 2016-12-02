<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticulierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civilite' , ChoiceType::class, array(
					'choices' => 
					array(
					
					'Madame' => 'Madame',
					'Mademoiselle' => 'Mademoiselle',
					'Monsieur' => 'Monsieur',
					)
					
					))
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance'  , DateType::class , array(
			'years' => range(1916, 2016)
			
			))
            ->add('lieuNaissance')
            ->add('naturePiece' , ChoiceType::class, array(
			'choices'  => array(
				'Choix' => "",
				'CNI' => 'CNI',
				'Carte Consulaire' => 'Carte Consulaire',
				'Passeport' => 'Passeport',
				'ONI' => 'ONI',
				'Permis de Conduire' => 'Permis de Conduire',
			), 
			) )
            ->add('numeroPiece')
            ->add('dateDelivrance'  , DateType::class , array(
			'years' => range(1916, 2016)
			
			))
            ->add('lieuDelivrance')
			->add('autre')
            ->add('telephone')
            ->add('cellulaire')
            ->add('numeroContribuable')
            ->add('lieuHabitation')
            ->add('adressePostale')
            ->add('nomSociete')
            ->add('profession')
            ->add('telBureau')
            ->add('adresseGeographique')
            ->add('nomContactUrgence')
            ->add('affiniteContactUrgence' , ChoiceType::class, array(
			'choices'  => array(
				'Choix' => "",
				'Ami(e)' => 'Ami(e)',
				'Parents' => 'Parents',
				'Collègue' => 'Collègue',
				'Partenaire' => 'Partenaire',
				'Autres' => 'Autres',
			), 
			))
            ->add('telContactUrgence')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Particulier'
        ));
    }
}
