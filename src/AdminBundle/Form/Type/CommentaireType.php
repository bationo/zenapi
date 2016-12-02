<?php

namespace ES\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentaireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('pseudo', 'text', array(
                'required' => true
            ))
            ->add('contenu', 'textarea', array(
                'required' => true
            ))
            ->add('commentaire', 'hidden', array(
                'mapped' => false,
                'required' => false
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ES\AdminBundle\Entity\Commentaire',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'commentaire';
    }
}
