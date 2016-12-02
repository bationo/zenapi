<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * admin
 *
 * @ORM\Table(name="admins")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\AdminRepository")
 */
class Admin
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, options={"default":""})
     *
     * @Assert\NotBlank(message="fos_user.name.blank", groups={"Registration", "Profile"})
     * @Assert\Length(
     *      min = "3",
     *      max = "255",
     *      minMessage = "fos_user.name.short",
     *      maxMessage = "fos_user.name.long",
     *      groups={"Registration", "Profile"}
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, options={"default":""})
     *
     * @Assert\NotBlank(message="fos_user.phone.blank", groups={"Registration", "Profile"})
     * @Assert\Length(
     *      min = "8",
     *      max = "255",
     *      minMessage = "fos_user.phone.short",
     *      maxMessage = "fos_user.phone.long",
     *      groups={"Registration", "Profile"}
     * )
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="fonction", type="string", length=255, options={"default":""})
     *
     * @Assert\NotBlank(message="fos_user.function.blank", groups={"Registration", "Profile"})
     * @Assert\Length(
     *      min = "3",
     *      max = "255",
     *      minMessage = "fos_user.function.short",
     *      maxMessage = "fos_user.function.long",
     *      groups={"Registration", "Profile"}
     * )
     */
    private $function;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Admin
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Admin
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set function
     *
     * @param string $function
     *
     * @return Admin
     */
    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }
}
