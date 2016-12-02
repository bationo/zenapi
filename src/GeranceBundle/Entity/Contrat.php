<?php

namespace GeranceBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contrat
 *
 * @ORM\Table(name="contrat")
 * @ORM\Entity(repositoryClass="GeranceBundle\Repository\ContratRepository")
 */
class Contrat
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat = true;
	
	/**
     * @ORM\ManyToOne(targetEntity="GeranceBundle\Entity\Locative", inversedBy="contrat")
     * @ORM\JoinColumn(name="locative_id", referencedColumnName="id", nullable=false)
     */
    private $locative; 
	

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSignature", type="date")
     */
    private $dateSignature;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date")
     */
    private $dateFin;

     /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Locataire", inversedBy="contrat")
     * @ORM\JoinColumn(name="locataire_id", referencedColumnName="id", nullable=false)
     */
    private $locataire;

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
     * @var datetime
     *
     * @ORM\Column(name="validite", type="datetime"  )
     */
    private $validite;
	
		
	/**
     * @var int
     *
     * @ORM\Column(name="limite", type="integer")
     */
    private $limite; 

	/**
     * @var int
     *
     * @ORM\Column(name="penalite", type="integer")
     */
    private $penalite; 
	
	
	/**
   * @ORM\OneToOne(targetEntity="GeranceBundle\Entity\FactContrat", cascade={"persist" , "remove" })
   * @ORM\JoinColumn( nullable=true)
   */
   private $contrat;
   
    /**
     * @ORM\OneToMany(targetEntity="GeranceBundle\Entity\Loyer", mappedBy="contrat" , cascade={"persist","remove"})
     */
    private $loyer;


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
     * Set type
     *
     * @param string $type
     *
     * @return Contrat
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dateSignature
     *
     * @param \DateTime $dateSignature
     *
     * @return Contrat
     */
    public function setDateSignature($dateSignature)
    {
        $this->dateSignature = $dateSignature;

        return $this;
    }

    /**
     * Get dateSignature
     *
     * @return \DateTime
     */
    public function getDateSignature()
    {
        return $this->dateSignature;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Contrat
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Contrat
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Contrat
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
     * @return Contrat
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
     * Set locataire
     *
     * @param \UserBundle\Entity\Locataire $locataire
     *
     * @return Contrat
     */
    public function setLocataire(\UserBundle\Entity\Locataire $locataire)
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
     * Set locative
     *
     * @param \GeranceBundle\Entity\Locative $locative
     *
     * @return Contrat
     */
    public function setLocative(\GeranceBundle\Entity\Locative $locative)
    {
        $this->locative = $locative;

        return $this;
    }

    /**
     * Get locative
     *
     * @return \GeranceBundle\Entity\Locative
     */
    public function getLocative()
    {
        return $this->locative;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return Contrat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean
     */
    public function getEtat()
    {
        return $this->etat;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->loyer = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set validite
     *
     * @param \DateTime $validite
     *
     * @return Contrat
     */
    public function setValidite($validite)
    {
        $this->validite = $validite;

        return $this;
    }

    /**
     * Get validite
     *
     * @return \DateTime
     */
    public function getValidite()
    {
        return $this->validite;
    }

    /**
     * Set limite
     *
     * @param integer $limite
     *
     * @return Contrat
     */
    public function setLimite($limite)
    {
        $this->limite = $limite;

        return $this;
    }

    /**
     * Get limite
     *
     * @return integer
     */
    public function getLimite()
    {
        return $this->limite;
    }

    /**
     * Set contrat
     *
     * @param \GeranceBundle\Entity\FactContrat $contrat
     *
     * @return Contrat
     */
    public function setContrat(\GeranceBundle\Entity\FactContrat $contrat = null)
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * Get contrat
     *
     * @return \GeranceBundle\Entity\FactContrat
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * Add loyer
     *
     * @param \GeranceBundle\Entity\Loyer $loyer
     *
     * @return Contrat
     */
    public function addLoyer(\GeranceBundle\Entity\Loyer $loyer)
    {
        $this->loyer[] = $loyer;

        return $this;
    }

    /**
     * Remove loyer
     *
     * @param \GeranceBundle\Entity\Loyer $loyer
     */
    public function removeLoyer(\GeranceBundle\Entity\Loyer $loyer)
    {
        $this->loyer->removeElement($loyer);
    }

    /**
     * Get loyer
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLoyer()
    {
        return $this->loyer;
    }

    /**
     * Set penalite
     *
     * @param integer $penalite
     *
     * @return Contrat
     */
    public function setPenalite($penalite)
    {
        $this->penalite = $penalite;

        return $this;
    }

    /**
     * Get penalite
     *
     * @return integer
     */
    public function getPenalite()
    {
        return $this->penalite;
    }
}
