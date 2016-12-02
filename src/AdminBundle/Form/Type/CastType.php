<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class CastType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('name', TextType::class, array(
                'required' => true
            ))
            ->add('function', TextType::class, array(
                'required' => true
            ))
            ->add('presentation', CKEditorType::class, array(
                'required' => true
            ))
            ->add('staring', CheckboxType::class, array(
                'label'    => 'A l\'affiche?',
                'required' => false
            ))
            ->add('image', ImageType::class, array(
                'required' => false
            ))
            ->add('publishedAt', DateTimeType::class, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy HH:mm',
                'required' => true
            ))
            ->add('state', EntityType::class, array(
                'label'         => 'Publier',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'choice_label'  => 'name',
                'class'         => 'AdminBundle\Entity\State',
                'query_builder' => function (\AdminBundle\Repository\StateRepository $er) {
                    return $er->findQbWithoutTrash();
                },
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Cast',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cast';
    }
}
