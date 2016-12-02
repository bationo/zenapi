<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocteurEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
           
			 
			
			->add('disponible', CollectionType::class, array(
        'entry_type'   => DisponibleType::class,
        'allow_add'    => true,
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
            'data_class' => 'AdminBundle\Entity\Docteur',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'docteur';
    }
}
