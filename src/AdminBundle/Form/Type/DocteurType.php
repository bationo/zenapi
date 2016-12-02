<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocteurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('nom')
            ->add('mail')
            ->add('tel')
			 ->add('titre', EntityType::class , array(

							  'class'    => 'AdminBundle:Titre',

							  'choice_label' => 'libele',

							  'multiple' => false,

							  'required' => true,


							) )
			->add('ListeSpecialite', EntityType::class , array(

							  'class'    => 'AdminBundle:ListeSpecialite',

							  'choice_label' => 'libele',

							  'multiple' => true,

							  'required' => true,


							) )
			->add('image', ImageType::class, array(
                'required' => false
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
