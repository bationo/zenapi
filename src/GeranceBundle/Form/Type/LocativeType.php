<?php

namespace GeranceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocativeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('porte')
            ->add('loyer')
            ->add('charge')
            ->add('piece')
            ->add('supercie')
            ->add('commentaire')
			->add('type' , ChoiceType::class, array(
                    'choices' => 
                    array(
                    'Faite un choix' => '',
                    'Palier' => 'Palier',
                    'Villa' => 'Villa',
					'Magasin' => 'Magasin',
					'Appartement' => 'Appartement',
					'Studio' => 'Studio',
                    )
                    
                    ))
			->add('meuble' , ChoiceType::class, array(
                    'choices' => 
                    array(
                    'Faite un choix' => '',
                    'OUI' => 1,
                    'NON' => 0
					
                    )
                    
                    ))
            
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GeranceBundle\Entity\Locative',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'locative';
    }
}
