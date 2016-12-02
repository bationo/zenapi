<?php

namespace GeranceBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Immobilier
 *
 * @ORM\Table(name="immobilier")
 * @ORM\Entity(repositoryClass="GeranceBundle\Repository\ImmobilierRepository")
 */
class Immobilier
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
     * @var string
     *
     * @ORM\Column(name="typeLocation", type="string", length=255 , nullable=true)
     */
    private $typeLocation;
	
	
	/**
     * @ORM\OneToOne(targetEntity="AdminBundle\Entity\Document",  cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=true)
     */
    private $document;
	
	/**
     * @ORM\OneToMany(targetEntity="\AdminBundle\Entity\Docs", mappedBy="immobilier", cascade={"persist", "remove"} , orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $justificatif;
	
	
	
    /**
     * @var boolean
     *
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="vente", type="boolean")
     */
    private $vente; 

	 /**
     * @var string
     *
     * @ORM\Column(name="lot", type="string" , length=255 , nullable=true)
     */
    private $lot;
	
	/**
     * @var string
     *
     * @ORM\Column(name="ilot", type="string" , length=255 , nullable=true)
     */
    private $ilot;
	
	/**
     * @var string
     *
     * @ORM\Column(name="titreFoncier", type="string" , length=255 , nullable=true)
     */
    private $titreFoncier;
	
	/**
     * @var string
     *
     * @ORM\Column(name="geographique", type="string" , length=255 )
     */
    private $geographique;
	
	/**
     * @var string
     *
     * @ORM\Column(name="superficie", type="string" , length=255 , nullable=true)
     */
    private $superficie;
	
	
	  /**
     * @var bool
     *
     * @ORM\Column(name="mandat", type="boolean")
     */
    private $mandat = false;
	
	
	 /**
     * @var boolean
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;
	
	
	/**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Proprietaire", inversedBy="immobilier")
     * @ORM\JoinColumn(name="proprietaire_id", referencedColumnName="id", nullable=false)
     */
    private $proprietaire; 
	
	/**
	 * @ORM\OneToMany(targetEntity="GeranceBundle\Entity\Locative", mappedBy="immobilier" , cascade={"persist","remove"})
	 */
	 private $locative;
	

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="commune", type="string", length=255)
     */
    private $commune;

    /**
     * @var string
     *
     * @ORM\Column(name="quartier", type="string", length=255)
     */
    private $quartier;



    /**
     * @var string
     *
     * @ORM\Column(name="commission", type="integer" )
     */
    private $commission;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text" , nullable=true)
     */
    private $description;

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
     * Set type
     *
     * @param string $type
     *
     * @return Immobilier
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Immobilier
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set commune
     *
     * @param string $commune
     *
     * @return Immobilier
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * Get commune
     *
     * @return string
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * Set quartier
     *
     * @param string $quartier
     *
     * @return Immobilier
     */
    public function setQuartier($quartier)
    {
        $this->quartier = $quartier;

        return $this;
    }

    /**
     * Get quartier
     *
     * @return string
     */
    public function getQuartier()
    {
        return $this->quartier;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Immobilier
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set commission
     *
     * @param string $commission
     *
     * @return Immobilier
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Immobilier
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Immobilier
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
     * @return Immobilier
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
     * Set etat
     *
     * @param boolean $etat
     *
     * @return Immobilier
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
     * Set montant
     *
     * @param boolean $montant
     *
     * @return Immobilier
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return boolean
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set proprietaire
     *
     * @param \UserBundle\Entity\Proprietaire $proprietaire
     *
     * @return Immobilier
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
        $this->locative = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add locative
     *
     * @param \GeranceBundle\Entity\Locative $locative
     *
     * @return Immobilier
     */
    public function addLocative(\GeranceBundle\Entity\Locative $locative)
    {
        $this->locative[] = $locative;

        return $this;
    }

    /**
     * Remove locative
     *
     * @param \GeranceBundle\Entity\Locative $locative
     */
    public function removeLocative(\GeranceBundle\Entity\Locative $locative)
    {
        $this->locative->removeElement($locative);
    }

    /**
     * Get locative
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocative()
    {
        return $this->locative;
    }

    /**
     * Set vente
     *
     * @param boolean $vente
     *
     * @return Immobilier
     */
    public function setVente($vente)
    {
        $this->vente = $vente;

        return $this;
    }

    /**
     * Get vente
     *
     * @return boolean
     */
    public function getVente()
    {
        return $this->vente;
    }

    /**
     * Set lot
     *
     * @param string $lot
     *
     * @return Immobilier
     */
    public function setLot($lot)
    {
        $this->lot = $lot;

        return $this;
    }

    /**
     * Get lot
     *
     * @return string
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * Set ilot
     *
     * @param string $ilot
     *
     * @return Immobilier
     */
    public function setIlot($ilot)
    {
        $this->ilot = $ilot;

        return $this;
    }

    /**
     * Get ilot
     *
     * @return string
     */
    public function getIlot()
    {
        return $this->ilot;
    }

    /**
     * Set titreFoncier
     *
     * @param string $titreFoncier
     *
     * @return Immobilier
     */
    public function setTitreFoncier($titreFoncier)
    {
        $this->titreFoncier = $titreFoncier;

        return $this;
    }

    /**
     * Get titreFoncier
     *
     * @return string
     */
    public function getTitreFoncier()
    {
        return $this->titreFoncier;
    }

    /**
     * Set geographique
     *
     * @param string $geographique
     *
     * @return Immobilier
     */
    public function setGeographique($geographique)
    {
        $this->geographique = $geographique;

        return $this;
    }

    /**
     * Get geographique
     *
     * @return string
     */
    public function getGeographique()
    {
        return $this->geographique;
    }

    /**
     * Set superficie
     *
     * @param string $superficie
     *
     * @return Immobilier
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;

        return $this;
    }

    /**
     * Get superficie
     *
     * @return string
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

 
    /**
     * Set document
     *
     * @param \AdminBundle\Entity\Document $document
     *
     * @return Immobilier
     */
    public function setDocument(\AdminBundle\Entity\Document $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \AdminBundle\Entity\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set mandat
     *
     * @param boolean $mandat
     *
     * @return Immobilier
     */
    public function setMandat($mandat)
    {
        $this->mandat = $mandat;

        return $this;
    }

    /**
     * Get mandat
     *
     * @return boolean
     */
    public function getMandat()
    {
        return $this->mandat;
    }

    /**
     * Add justificatif
     *
     * @param \AdminBundle\Entity\Docs $justificatif
     *
     * @return Immobilier
     */
    public function addJustificatif(\AdminBundle\Entity\Docs $justificatif)
    {
        $this->justificatif[] = $justificatif;
		

        return $this;
    }

    /**
     * Remove justificatif
     *
     * @param \AdminBundle\Entity\Docs $justificatif
     */
    public function removeJustificatif(\AdminBundle\Entity\Docs $justificatif)
    {
        $this->justificatif->removeElement($justificatif);
    }

    /**
     * Get justificatif
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJustificatif()
    {
        return $this->justificatif;
    }

    /**
     * Set typeLocation
     *
     * @param string $typeLocation
     *
     * @return Immobilier
     */
    public function setTypeLocation($typeLocation)
    {
        $this->typeLocation = $typeLocation;

        return $this;
    }

    /**
     * Get typeLocation
     *
     * @return string
     */
    public function getTypeLocation()
    {
        return $this->typeLocation;
    }
}
