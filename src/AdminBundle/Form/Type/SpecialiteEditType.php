<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialiteEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $vocId = 1;
		$builder
        
            ->add('prix')
			 
			->add('libele',EntityType::class,array(
            'class' => 'AdminBundle:ListeSpecialite',
            'required' => false,
            'query_builder' => function (\AdminBundle\Repository\ListeSpecialite $er) use ($vocId) {
                return $er->createQueryBuilder('s')
                   ;
            }
        ));
           
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Specialite',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'specialite';
    }
}
