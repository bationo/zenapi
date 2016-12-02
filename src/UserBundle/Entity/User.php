<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * admin
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 *
 * @UniqueEntity(fields="usernameCanonical", errorPath="username", message="fos_user.username.already_used", groups={"default", "Registration", "Profile"})
 * @UniqueEntity(fields="emailCanonical", errorPath="email", message="fos_user.email.already_used", groups={"default", "Registration", "Profile"})
 */
class User extends BaseUser
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
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\UserGroup", inversedBy="users")
     * @ORM\JoinTable(name="users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
	
	
	 /**
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "votre mot de passe doit comporter au moins 6 caractères",
     * )
     */
    protected $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255)
     */
    private $avatar;
	
	
	 /**
     * @ORM\OneToMany(targetEntity="\AdminBundle\Entity\Docs", mappedBy="user", cascade={"persist", "remove"} , orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $document;
	
	


    /**
     * @var string
     *
     * @Assert\Image(maxSize="6000000")
     */
    private $tempFile;

    /**
     * @var string
     */
    private $tempFileName;

    /**
     * @ORM\OneToOne(targetEntity="AdminBundle\Entity\Profil", mappedBy="user" ,  cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $profil;
	
	 /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Proprietaire", mappedBy="user" ,  cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $proprietaire;
	
	/**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Locataire", mappedBy="user" ,  cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $locataire;
	
	
	
	/**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Pays" , cascade={"persist"} )
	 * @ORM\JoinColumn(nullable=true)
     */
    private $pays; 
	
	
    /**
     * @ORM\OneToOne(targetEntity="AdminBundle\Entity\Post", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $star;

    /**
     * @ORM\OneToOne(targetEntity="AdminBundle\Entity\Admin", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $admin;


    public function __construct()
    {
        parent::__construct();

        $this->groups = new ArrayCollection();

        $this->avatar = 'png';
    }


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
     * Set profil
     *
     * @param \AdminBundle\Entity\Profil $profil
     *
     * @return User
     */
    public function setProfil(\AdminBundle\Entity\Profil $profil = null)
    {
		$profil->setUser($this);
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return \AdminBundle\Entity\Profil
     */
    public function getProfil()
    {
		
        return $this->profil;
    }

    /**
     * Set star
     *
     * @param \AdminBundle\Entity\Post $star
     *
     * @return User
     */
    public function setStar(\AdminBundle\Entity\Post $star = null)
    {
        $this->star = $star;

        return $this;
    }

    /**
     * Get star
     *
     * @return \AdminBundle\Entity\Post
     */
    public function getStar()
    {
        return $this->star;
    }

    /**
     * Set admin
     *
     * @param \AdminBundle\Entity\Admin $admin
     *
     * @return User
     */
    public function setAdmin(\AdminBundle\Entity\Admin $admin = null)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return \AdminBundle\Entity\Admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set tempFile
     *
     * @param string $tempFile
     *
     * @return User
     */
    public function setTempFile($tempFile)
    {
        $this->tempFile = $tempFile;

        if (null !== $this->avatar) {

            $this->tempFileName = $this->avatar;

            $this->avatar = null;
        }

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getTempFile()
    {
        return $this->tempFile;
    }

    public function getTempFileName()
    {
        return $this->tempFileName;
    }

    public function setTempFileName($tempFileName)
    {
        $this->tempFileName = $tempFileName;

        return $this;
    }

    public function getWebPath()
    {
        $absolutePath = $this->getUploadDir().'/'.$this->getId().'.'.$this->getAvatar();

        if(file_exists($absolutePath)) {
            return $absolutePath;
        }

        return $this->getUploadDir().'/avatar.png';
    }

    public function getUploadDir()
    {
        return 'uploads/avatars';
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    function getEnabled() {
        return $this->enabled;
    }

    function getLocked() {
        return $this->locked;
    }

    function getExpired() {
        return $this->expired;
    }

    function getExpiresAt() {
        return $this->expiresAt;
    }

    function getCredentialsExpired() {
        return $this->credentialsExpired;
    }

    function getCredentialsExpireAt() {
        return $this->credentialsExpireAt;
    }

    function setSalt($salt) {
        $this->salt = $salt;
    }

    public function setPassword($password) {
        if ($password !== null)
            $this->password = $password;
        return $this;
    }

    function setGroups(ArrayCollection $groups = null) {
        if ($groups !== null)
            $this->groups = $groups;
    }

    public function setRoles(array $roles = array()) {
        $this->roles = array();
        foreach ($roles as $role)
            $this->addRole($role);
        return $this;
    }

    public function hasGroup($name = '') {
        return in_array($name, $this->getGroupNames());
    }


    /**
     * Get message
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set proprietaire
     *
     * @param \UserBundle\Entity\Proprietaire $proprietaire
     *
     * @return User
     */
    public function setProprietaire(\UserBundle\Entity\Proprietaire $proprietaire = null)
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * Get proprietaire
     *
     * @return \UserBundle\Entity\Proprietaire
     */
    public function getProprietaire()
    {
        return $this->proprietaire;
    }

    /**
     * Set locataire
     *
     * @param \UserBundle\Entity\Locataire $locataire
     *
     * @return User
     */
    public function setLocataire(\UserBundle\Entity\Locataire $locataire = null)
    {
        $this->locataire = $locataire;

        return $this;
    }

    /**
     * Get locataire
     *
     * @return \UserBundle\Entity\Locataire
     */
    public function getLocataire()
    {
        return $this->locataire;
    }

    /**
     * Add document
     *
     * @param \AdminBundle\Entity\Docs $document
     *
     * @return User
     */
    public function addDocument(\AdminBundle\Entity\Docs $document)
    {
        $this->document[] = $document;
		$document->setUser($this);

        return $this;
    }

    /**
     * Remove document
     *
     * @param \AdminBundle\Entity\Docs $document
     */
    public function removeDocument(\AdminBundle\Entity\Docs $document)
    {
        $this->document->removeElement($document);
    }

    /**
     * Get document
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocument()
    {
        return $this->document;
    }



    /**
     * Set pays
     *
     * @param \AdminBundle\Entity\Pays $pays
     *
     * @return User
     */
    public function setPays(\AdminBundle\Entity\Pays $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \AdminBundle\Entity\Pays
     */
    public function getPays()
    {
        return $this->pays;
    }
}
