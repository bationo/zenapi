<?php

namespace UserBundle\Form\Type;use FOS\UserBundle\Util\LegacyFormHelper;use Symfony\Component\Form\AbstractType;use Symfony\Component\Form\FormBuilderInterface;use Symfony\Component\OptionsResolver\OptionsResolver;use Symfony\Component\Form\Extension\Core\Type\TextType;use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;use Symfony\Component\Form\Extension\Core\Type\FileType;use Symfony\Bridge\Doctrine\Form\Type\EntityType;use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class InscriptionParticulierType extends BaseType
{
    /**
     * @param string $class The User class name
     */
    public function __construct()
    {
        parent::__construct('UserBundle\Entity\User');
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)    {
        parent::buildForm($builder, $options);

            $builder			->add('proprietaire',  ProprietaireParticulierType::class )			 ->add('pays', EntityType::class , array(							  'class'    => 'AdminBundle:Pays',							  'choice_label' => 'nom',							  'multiple' => false,							  'required' => true,							) )			->add('tempFile', FileType::class, array( 'required' => false, 'label' => "Image de profil" ))			->add('document', CollectionType::class, array(            'entry_type'   => \AdminBundle\Form\Type\DocsType::class,             'allow_add' => true,              'allow_delete' => true,			  'by_reference' => false                        ))
			->remove('username')			
			
		;		if ($options['passwordRequired'] == false) {            $builder->remove("plainPassword");        }

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'passwordRequired' => true,
            'lockedRequired' => false,
            'groupsRequired' => true,
            'profilRequired' => false,
            'cvRequired' => false,
            'adminRequired' => false,
            'csrf_token_id' => 'registration',
            // BC for SF < 2.8
            'intention'  => 'registration',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }
}
