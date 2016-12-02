<?php

namespace FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use AdminBundle\Entity\Place;

class TicketType extends AbstractType
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
            ->add('phone', TextType::class, array(
                'required' => true
            ))
            ->add('address', TextareaType::class, array(
                'required' => true,
                'attr'     => array(
                    'rows' => 4,
                )
            ))
            ->add('place', EntityType::class, array(
                'label'         => 'Lieu de diffusion',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                //'choice_label'  => 'title',
                'class'         => 'AdminBundle\Entity\Place',
            ))
            ->add('ticketNumber', IntegerType::class, array(
                'required' => true,
                'attr'     => array(
                    'value' => 1,
                    'min'   => 1,
                )
            ))
            ->add('total', TextType::class, array(
                'mapped'   => false,
                'required' => false,
                'disabled' => true,
                'attr'     => array(
                    'class' => 'disabled'
                )
            ))
            ->add('route', HiddenType::class, array(
                'mapped' => false,
                'required' => false,
            ))
            ->add('parameters', HiddenType::class, array(
                'mapped' => false,
                'required' => false,
            ))
        ;

        $formModifier = function (FormInterface $form, Place $place = null) {
            $price = null === $place ? '' : $place->getPrice();

            $form->add('price', TextType::class, array(
                'mapped'   => false,
                'attr'     => array(
                    'value' => $price,
                    'class' => 'disabled',
                )
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. Ticket
                $data = $event->getData();

                //$formModifier($event->getForm(), $data->getPlace());
            }
        );

        $builder->get('place')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $place = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $place);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Ticket',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ticket';
    }
}
