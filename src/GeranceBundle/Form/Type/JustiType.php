<?php

namespace GeranceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JustiType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
       
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
