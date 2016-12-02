<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TicketType extends AbstractType
{
  
	
	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
               ->add('titre')
			   ->add('message', CollectionType::class, array(
				'entry_type'   => MessageType::class, 
				'entry_options'  => array(
					'id' => $options['id']
				),
				'allow_add'    => true,
				'allow_delete' => true,
				'by_reference' => false
				
				))
				
			  ->add('service' , ChoiceType::class, array(
								'choices'   => array('Technique/Technical' => 'Technique/Technical', 'Commercial/Sales' => 'Commercial/Sales'),
							))
			  ->add('priorite' , ChoiceType::class, array(
								'choices'   => array('Moyenne' => 'Moyenne', 'Haute' => 'Haute' , 'Faible' => 'Faible'),
							))
            
        ;
    }
    
	
	
	
	
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Ticket',
			'id' => ""
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'es_adminbundle_ticket';
    }
}
