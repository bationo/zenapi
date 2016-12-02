<?php

namespace UserBundle\Form\Type;

class InscriptionEntrepriseType extends BaseType
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
     $builder
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