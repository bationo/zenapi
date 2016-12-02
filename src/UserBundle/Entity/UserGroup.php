<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group as BaseGroup;

/**
 * UserGroup
 *
 * @ORM\Table(name="user_groups")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserGroupRepository")
 */
class UserGroup extends BaseGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", mappedBy="groups")
     *
     */
    protected $users;

    public function __construct($name = '', $roles = array()) {
        $this->name  = $name;
        $this->roles = $roles;
    }

    public function __toString() {
        return $this->getName();
    }

    function getUsers() {
        return $this->users;
    }

    /**
     * Add user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return UserGroup
     */
    public function addUser(\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \UserBundle\Entity\User $user
     */
    public function removeUser(\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }
}

