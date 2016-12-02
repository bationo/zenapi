<?php

namespace GeranceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratType extends AbstractType
{
private $data;	
	
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		 $this->data = $options['data'];
		 
        $builder
        
            ->add('type' , ChoiceType::class, array(
                    'choices' => 
                    array(
                    
                    'Contrat de bail habitation' => 'Contrat de bail habitation',
                    'Contrat de bail commercial' => 'Contrat de bail commercial',
                    )
                    
                    ))
			
			->add('limite' , ChoiceType::class, array(
                    'choices' => 
                    array(
                    
                    1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10,
					11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20,
					21 => 21, 22 => 22, 23 => 23, 24 => 24, 25 => 25, 26 => 26, 27 => 27, 28 => 28, 29 => 29, 30 => 30, 31 => 31,
					
                    )
                    
                    ))
			->add('dateSignature')
            ->add('dateDebut')
			->add('penalite')
            ->add('dateFin')
            ->add('contrat' , FactContratType::class )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GeranceBundle\Entity\Contrat',
			"data" => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'contrat';
    }
}
