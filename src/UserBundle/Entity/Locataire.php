<?php

namespace UserBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Locataire
 *
 * @ORM\Table(name="locataire")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\LocataireRepository")
 */
class Locataire
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
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="locataire" , cascade={"persist", "remove"})
	 *@ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
	
	/**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\EntrepriseLocataire", mappedBy="locataire" ,  cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $entreprise;


	
	 /**
     * @ORM\OneToMany(targetEntity="GeranceBundle\Entity\Facture", mappedBy="locataire" , cascade={"persist","remove"})
     */
    private $facture;

	
	/**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\ParticulierLocataire", mappedBy="locataire" ,  cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $particulier;


    /**
     * @ORM\OneToMany(targetEntity="GeranceBundle\Entity\Contrat", mappedBy="locataire" , cascade={"persist","remove"})
     */
     private $contrat;
	

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
     * @return Locataire
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
     * @return Locataire
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
     * @return Locataire
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
     * @param \UserBundle\Entity\EntrepriseLocataire $entreprise
     *
     * @return Locataire
     */
    public function setEntreprise(\UserBundle\Entity\EntrepriseLocataire $entreprise = null)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \UserBundle\Entity\EntrepriseLocataire
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * Set particulier
     *
     * @param \UserBundle\Entity\ParticulierLocataire $particulier
     *
     * @return Locataire
     */
    public function setParticulier(\UserBundle\Entity\ParticulierLocataire $particulier = null)
    {
        $this->particulier = $particulier;

        return $this;
    }

    /**
     * Get particulier
     *
     * @return \UserBundle\Entity\ParticulierLocataire
     */
    public function getParticulier()
    {
        return $this->particulier;
    }

    /**
     * Set proprietaire
     *
     * @param \UserBundle\Entity\Proprietaire $proprietaire
     *
     * @return Locataire
     */
    public function setProprietaire(\UserBundle\Entity\Proprietaire $proprietaire)
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
     * Constructor
     */
    public function __construct()
    {
        $this->contrat = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add contrat
     *
     * @param \GeranceBundle\Entity\Contrat $contrat
     *
     * @return Locataire
     */
    public function addContrat(\GeranceBundle\Entity\Contrat $contrat)
    {
        $this->contrat[] = $contrat;

        return $this;
    }

    /**
     * Remove contrat
     *
     * @param \GeranceBundle\Entity\Contrat $contrat
     */
    public function removeContrat(\GeranceBundle\Entity\Contrat $contrat)
    {
        $this->contrat->removeElement($contrat);
    }

    /**
     * Get contrat
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContrat()
    {
        return $this->contrat;
    }
	
	    /**
     * Add facture
     *
     * @param \GeranceBundle\Entity\Facture $facture
     *
     * @return Locataire
     */
    public function addFacture(\GeranceBundle\Entity\Facture $facture)
    {
        $this->facture[] = $facture;

        return $this;
    }

    /**
     * Remove facture
     *
     * @param \GeranceBundle\Entity\Facture $facture
     */
    public function removeFacture(\GeranceBundle\Entity\Facture $facture)
    {
        $this->facture->removeElement($facture);
    }

    /**
     * Get facture
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacture()
    {
        return $this->facture;
    }
}
