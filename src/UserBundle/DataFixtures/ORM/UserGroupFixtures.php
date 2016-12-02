<?php 

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager; 
use Doctrine\Common\DataFixtures\AbstractFixture; 
use Doctrine\Common\DataFixtures\OrderedFixtureInterface; 
use Symfony\Component\DependencyInjection\ContainerAwareInterface; 
use Symfony\Component\DependencyInjection\ContainerInterface; 
use UserBundle\Entity\UserGroup;

class UserGroupFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        return 1;
    }
 
    /** 
     * {@inheritDoc} 
     */ 
    public function load(ObjectManager $manager) 
    {
 
        $superGroup = new UserGroup('Super Administrateur');
        $superGroup->addRole('ROLE_SUPER_ADMIN');

        $adminsGroup = new UserGroup('Administrateur');
        $adminsGroup->addRole('ROLE_ADMIN');

        $starsGroup = new UserGroup('Proprietaire');
        $starsGroup->addRole('ROLE_PRO');
        
        $profilsGroup = new UserGroup('Locataire');
        $profilsGroup->addRole('ROLE_USER');
        
        $manager->persist($superGroup);
        $manager->persist($adminsGroup);
        $manager->persist($starsGroup);
        $manager->persist($profilsGroup);
 
        $manager->flush();
 
        $this->addReference('super-group', $superGroup);
    }
     
}