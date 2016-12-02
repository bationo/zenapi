<?php

namespace UserBundle\Form\Type;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use AdminBundle\Form\Type\ProfilType;
use AdminBundle\Form\Type\PostType;
use AdminBundle\Form\Type\AdminType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends BaseType
{
    /**
     * @param string $class The admin class name
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
            ->add('tempFile', FileType::class, array( 'required' => false, 'label' => "Avatar de l'utilisateur" ))
            ->remove('plainPassword')
        ;
        if ($options['passwordRequired']) {
            $builder->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ));
        } else {
            $builder->add('current_password', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'), array(
                'label' => 'form.current_password',
                'translation_domain' => 'FOSUserBundle',
                'mapped' => false,
                'constraints' => new UserPassword(),
            ));
        }
        if ($options['groupsRequired']) {
            $builder->add('groups', EntityType::class, array(
                'label' => 'Groupes',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'class' => 'UserBundle\Entity\UserGroup'
            ));
        }
        if ($options['profilRequired']) {
            $builder->add('profil', ProfilType::class);
        }
        if ($options['adminRequired']) {
            $builder->add('admin', AdminType::class);
        }
        if ($options['lockedRequired']) {
            $builder->add('locked', null, array('required' => false, 
                'label' => 'Vérouiller le compte'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'passwordRequired' => true,
            'lockedRequired'   => false,
            'groupsRequired'   => true,
            'profilRequired'   => false,
            'category'         => null,
            'adminRequired'    => false,
            'csrf_token_id'    => 'registration',
            // BC for SF < 2.8
            'intention'        => 'registration',
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
