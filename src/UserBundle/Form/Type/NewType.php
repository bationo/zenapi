<?php
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class NewType extends BaseType
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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        
       
       
      
            $builder->add('profil',  \AdminBundle\Form\Type\NewType::class )
			->remove('username')
			
		;

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