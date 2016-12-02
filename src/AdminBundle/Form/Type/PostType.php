<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class PostType extends AbstractType
{
    private $category;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->category = $options['category'];

        $builder
            ->add('title', TextType::class, array(
                'required' => true
            ))
            ->add('content', CKEditorType::class, array(
                'required' => true
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
            ->add('categories', EntityType::class, array(
                'label'         => 'Catégories article',
                'multiple'      => true,
                'expanded'      => true,
                'required'      => false,
                'choice_label'  => 'name',
                'class'         => 'AdminBundle\Entity\SubCategory',
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
            ->add('image', ImageType::class, array(
                'required' => false
            ))
        ;
        if ($options['starRequired']) {
            $builder->add('star', StarType::class);
        }
        if ($options['affairageRequired']) {
            $builder->add('affairage', AffairageType::class);
        }
        if ($options['showtimeRequired']) {
            $builder->add('showtime', ShowtimeType::class);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AdminBundle\Entity\Post',
            'category'          => null,
            'starRequired'      => false,
            'affairageRequired' => false,
            'showtimeRequired'  => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'post';
    }
}
