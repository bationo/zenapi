<?php 

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager; 
use Doctrine\Common\DataFixtures\AbstractFixture; 
use Doctrine\Common\DataFixtures\OrderedFixtureInterface; 
use Symfony\Component\DependencyInjection\ContainerAwareInterface; 
use Symfony\Component\DependencyInjection\ContainerInterface; 
use UserBundle\Entity\User;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface 
{ 

    /** 
     * @var ContainerInterface 
     */ 
    private $container; 

    /** 
     * {@inheritDoc} 
     */ 
    public function setContainer(ContainerInterface $container = null) { 
        $this->container = $container;
    }
     
    public function getOrder() {
        return 2;
    }
 
    public function load(ObjectManager $manager) {
 
        $userManager = $this->container->get('fos_user.user_manager');
         
        $user = $userManager->createUser();
         
        $user
            ->setUsername('admin')
            ->setEmail('aristide.bationo@eweb-solution.com')
            ->setPlainPassword('admin')
            ->setEnabled(true)
            ->setLocked(false)
            ->addGroup($this->getReference('super-group'));

        $admin = new \AdminBundle\Entity\Admin();

        $admin
            ->setName("admin")
            ->setPhone("+225 08 87 46 97")
            ->setFunction("Super Administrateur")
        ;

        $user->setAdmin($admin);
         
        $userManager->updateUser($user);

        $this->addReference('super-user', $user);
    }
     
}