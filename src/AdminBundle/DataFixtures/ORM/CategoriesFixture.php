<?php
/**
 * Created by PhpStorm.
 * User: DONIKAN
 * Date: 02/07/2016
 * Time: 15:43
 */

namespace AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AdminBundle\Entity\Category;

class CategoriesFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        return 4;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $names = ['Article', 'Affairage', 'Célébrité', 'Showtime', 'News'];

        foreach ($names as $name) {
            $category = new Category($name);
            $category->setCreatedBy($this->getReference('super-user'));
            $category->setUpdatedBy($this->getReference('super-user'));

            $manager->persist($category);
        }

        $manager->flush();
    }

}