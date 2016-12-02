<?php

namespace GeranceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FactureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
          ->add('optionFacture', CollectionType::class, array(
            'entry_type'   => OptionFactureType::class,
             'allow_add' => true,
              'allow_delete' => true,
            
            ))
			
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GeranceBundle\Entity\Facture',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'facture';
    }
}
