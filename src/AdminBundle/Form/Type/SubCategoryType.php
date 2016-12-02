<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SubCategoryType extends AbstractType
{
    private $category;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->category = $options['category'];

        $builder
            ->add('name', TextType::class, array(
                'required' => true
            ))
            ->add('parent', EntityType::class, array(
                'label'         => 'Catégories',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => false,
                'empty_data'    => null,
                'class'         => 'AdminBundle\Entity\SubCategory',
                'choice_label'  => 'name',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('s')
                        ->select('s, c')
                        ->innerJoin('s.category', 'c');
                    if ($this->category) {
                        $qb->where('c.id = :category')
                            ->setParameter('category', $this->category->getId());
                    }
                    $qb->orderBy('s.name', 'ASC');
                    return $qb;
                },
            ))
            ->add('slug', HiddenType::class, array(
                'mapped' => false
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\SubCategory',
            'category' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'subcategory';
    }
}
