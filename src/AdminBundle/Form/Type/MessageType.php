<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MessageType extends AbstractType
{
    
	
	
	
	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$this->id = $options['id'];
		
        $builder
            ->add('contenu')
			->add('image',  ImageType::class , array('required' => false))
        ;
		 if ($options['id']){
			 $builder
			 ->add('user' , EntityType::class , array(
				'class' => 'UserBundle:User',
				'choice_label' => 'username',
				'query_builder'=> function(\UserBundle\Repository\UserRepository $repository) { 
					return $repository->createQueryBuilder('u')->where('u.id = ?1')->setParameter(1, $this->id );
					},
				) );
			 
		 }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Message',
			'id' => ''
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'es_adminbundle_message';
    }
}
