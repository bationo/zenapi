<?php

namespace GeranceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImmobilierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('type' , ChoiceType::class, array(
					'choices' => 
					array(
					'Faite un choix' => '',
					'Immeuble' => 'Immeuble',
					'Maison Basse' => 'Maison Basse',
					'Duplex' => 'Duplex',
					'Villa' => 'Villa',
					'Appartement' => 'Appartement',
					'Terrain' => 'Terrain',
					)
					
					))
            ->add('vente' , ChoiceType::class, array(
                    'choices' => 
                    array(
                    'Faite un choix' => '',
                    'Non' => '0',
                    'Oui' => '1',
                    )
                    
                    ))
			 ->add('typeLocation' , ChoiceType::class, array(
                    'choices' => 
                    array(
                    'Faite un choix' => '',
                    'Palier' => 'Palier',
                    'Appartement' => 'Appartement',
                    )
                    
                    ))
            ->add('montant')
            ->add('nom')
            ->add('commune')
            ->add('quartier')
            ->add('commission')
            ->add('description')
			->add('lot')
			->add('ilot')
			->add('titreFoncier')
			->add('geographique')
			->add('superficie')
			->add('justificatif', CollectionType::class, array(
            'entry_type'   => \AdminBundle\Form\Type\DocsType::class,
             'allow_add' => true,
              'allow_delete' => true,
			  'by_reference' => false
            
            ))
			
           
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GeranceBundle\Entity\Immobilier',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'immobilier';
    }
}
