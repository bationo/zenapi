<?php
/**
 * Created by PhpStorm.
 * User: DONIKAN
 * Date: 02/07/2016
 * Time: 04:52
 */

namespace AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AdminBundle\Entity\State;

class StateFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $published = new State("Publié");
        $published->setCreatedBy($this->getReference('super-user'));
        $published->setUpdatedBy($this->getReference('super-user'));

        $bind_review = new State("En attente de relecture");
        $bind_review->setCreatedBy($this->getReference('super-user'));
        $bind_review->setUpdatedBy($this->getReference('super-user'));

        $draft = new State("Brouillon");
        $draft->setCreatedBy($this->getReference('super-user'));
        $draft->setUpdatedBy($this->getReference('super-user'));

        $trash = new State("Corbeille");
        $trash->setCreatedBy($this->getReference('super-user'));
        $trash->setUpdatedBy($this->getReference('super-user'));

        $manager->persist($published);
        $manager->persist($bind_review);
        $manager->persist($draft);
        $manager->persist($trash);

        $manager->flush();

        $this->addReference('published-state', $published);
        $this->addReference('bind-review-state', $bind_review);
    }

}