<?php

namespace UserBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Proprietaire
 *
 * @ORM\Table(name="proprietaire")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\ProprietaireRepository")
 */
class Proprietaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
	/**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="proprietaire" , cascade={"persist", "remove"} , fetch="EAGER")
	 *@ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
	
	/**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Entreprise", mappedBy="proprietaire" ,  cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $entreprise;
	
	/**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Particulier", mappedBy="proprietaire" ,  cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $particulier;
	
	/**
	 * @ORM\OneToMany(targetEntity="GeranceBundle\Entity\Immobilier", mappedBy="proprietaire" , cascade={"persist","remove"})
	 */
	 private $immobilier;
	
  	
	/**
     * @var datetime
     *
     * @ORM\Column(name="created", type="datetime"  )  
	 * @Gedmo\Timestampable(on="create")
     */
	 
	  private $created;

    /**
     * @var datetime
     *
     * @ORM\Column(name="modified", type="datetime"  )
	 * @Gedmo\Timestampable(on="update")
     */
    private $modified;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Proprietaire
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Proprietaire
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Proprietaire
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set entreprise
     *
     * @param \UserBundle\Entity\Entreprise $entreprise
     *
     * @return Proprietaire
     */
    public function setEntreprise(\UserBundle\Entity\Entreprise $entreprise = null)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \UserBundle\Entity\Entreprise
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * Set particulier
     *
     * @param \UserBundle\Entity\Particulier $particulier
     *
     * @return Proprietaire
     */
    public function setParticulier(\UserBundle\Entity\Particulier $particulier = null)
    {
        $this->particulier = $particulier;

        return $this;
    }

    /**
     * Get particulier
     *
     * @return \UserBundle\Entity\Particulier
     */
    public function getParticulier()
    {
        return $this->particulier;
    }
 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->immobilier = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add immobilier
     *
     * @param \GeranceBundle\Entity\Immobilier $immobilier
     *
     * @return Proprietaire
     */
    public function addImmobilier(\GeranceBundle\Entity\Immobilier $immobilier)
    {
        $this->immobilier[] = $immobilier;

        return $this;
    }

    /**
     * Remove immobilier
     *
     * @param \GeranceBundle\Entity\Immobilier $immobilier
     */
    public function removeImmobilier(\GeranceBundle\Entity\Immobilier $immobilier)
    {
        $this->immobilier->removeElement($immobilier);
    }

    /**
     * Get immobilier
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImmobilier()
    {
        return $this->immobilier;
    }

    /**
     * Add locataire
     *
     * @param \UserBundle\Entity\Locataire $locataire
     *
     * @return Proprietaire
     */
    public function addLocataire(\UserBundle\Entity\Locataire $locataire)
    {
        $this->locataire[] = $locataire;

        return $this;
    }

    /**
     * Remove locataire
     *
     * @param \UserBundle\Entity\Locataire $locataire
     */
    public function removeLocataire(\UserBundle\Entity\Locataire $locataire)
    {
        $this->locataire->removeElement($locataire);
    }

    /**
     * Get locataire
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocataire()
    {
        return $this->locataire;
    }
}
