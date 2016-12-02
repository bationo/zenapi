<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SettingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'required' => true
            ))
            ->add('keywords', TextareaType::class, array(
                'required' => true
            ))
            ->add('description', TextareaType::class, array(
                'required' => true
            ))
            ->add('trailer', TextType::class, array(
                'required' => true
            ))
            ->add('about', CKEditorType::class, array(
                'required' => true
            ))
            ->add('menuImage', ImageType::class, array(
                'required' => false
            ))
            ->add('backgroundImages', CollectionType::class, array(
                'entry_type'   => ImageType::class,
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
            'data_class' => 'AdminBundle\Entity\Setting',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'setting';
    }
}
