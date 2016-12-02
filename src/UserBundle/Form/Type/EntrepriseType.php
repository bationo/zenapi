<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raisonSocial')
			->add('autre')
            ->add('formeJuridique')
            ->add('adressePostale')
            ->add('siege')
            ->add('compteContribuable')
            ->add('registreCommerce')
            ->add('telBureau')
            ->add('fax')
            ->add('gerantCivilite' , ChoiceType::class, array(
					'choices' => 
					array(
					
					'Madame' => 'Madame',
					'Mademoiselle' => 'Mademoiselle',
					'Monsieur' => 'Monsieur',
					)
					
					))
            ->add('gerantNom')
            ->add('gerantPrenom')
            ->add('gerantDateNaissance' , DateType::class , array(
			'years' => range(1916, 2016)
			
			))
            ->add('gerantLieuNaissance')
            ->add('gerantNaturePiece' , ChoiceType::class, array(
			'choices'  => array(
				'Choix' => "",
				'CNI' => 'CNI',
				'Carte Consulaire' => 'Carte Consulaire',
				'Passeport' => 'Passeport',
				'ONI' => 'ONI',
				'Permis de Conduire' => 'Permis de Conduire',
			), 
			))
            ->add('gerantNumeroPiece')
            ->add('gerantDateDelivrance' , DateType::class , array(
			'years' => range(1916, 2016))
			)
            ->add('gerantLieuDelivrance')
            ->add('gerantTelephone')
            ->add('gerantCellulaire')
            ->add('gerantProfession')
            ->add('gerantMail')
            ->add('gerantLieuHabitation')
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
			) )
            ->add('telContactUrgence')
            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Entreprise'
        ));
    }
}
