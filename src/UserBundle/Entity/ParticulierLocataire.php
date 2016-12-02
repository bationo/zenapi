<?php

namespace UserBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * ParticulierLocataire
 *
 * @ORM\Table(name="particulier_locataire")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\ParticulierLocataireRepository")
 */
class ParticulierLocataire
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
     * @ORM\Column(name="civilite", type="string", length=255)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var date
     *
     * @ORM\Column(name="dateNaissance", type="date", length=255, nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuNaissance", type="string", length=255, nullable=true)
     */
    private $lieuNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="naturePiece", type="string", length=255, nullable=true)
     */
    private $naturePiece;
	
	/**
     * @var string
     *
     * @ORM\Column(name="numeroPiece", type="string", length=255, nullable=true)
     */
    private $numeroPiece;
	
	/**
     * @var datetime
     *
     * @ORM\Column(name="dateDelivrance", type="date",  nullable=true)
     */
    private $dateDelivrance;

	/**
     * @var string
     *
     * @ORM\Column(name="lieuDelivrance", type="string", length=255, nullable=true)
     */
    private $lieuDelivrance;


	/**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    private $telephone;	
	
	
	/**
     * @var string
     *
     * @ORM\Column(name="cellulaire", type="string", length=255, nullable=true)
     */
    private $cellulaire;	

	/**
     * @var string
     *
     * @ORM\Column(name="nomSociete", type="string", length=255, nullable=true)
     */
    private $nomSociete;
	
	/**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=255, nullable=true)
     */
    private $profession;
	
	/**
     * @var string
     *
     * @ORM\Column(name="telBureau", type="string", length=255, nullable=true)
     */
    private $telBureau;

	/**
     * @var string
     *
     * @ORM\Column(name="adresseGeographique", type="string", length=255, nullable=true)
     */
    private $adresseGeographique;

   /**
     * @var string
     *
     * @ORM\Column(name="nomContactUrgence", type="string", length=255, nullable=true)
     */
    private $nomContactUrgence;

    /**
     * @var string
     *
     * @ORM\Column(name="affiniteContactUrgence", type="string", length=255, nullable=true)
     */
    private $affiniteContactUrgence;

    /**
     * @var string
     *
     * @ORM\Column(name="telContactUrgence", type="string", length=255 , nullable=true)
     */
    private $telContactUrgence;
	

	
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
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=255)
     */
    private $nationalite;


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
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return ParticulierLocataire
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set civilite
     *
     * @param string $civilite
     *
     * @return ParticulierLocataire
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return ParticulierLocataire
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return ParticulierLocataire
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaissance
     *
     * @param datetime $dateNaissance
     *
     * @return ParticulierLocataire
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return datetime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set lieuNaissance
     *
     * @param string $lieuNaissance
     *
     * @return ParticulierLocataire
     */
    public function setLieuNaissance($lieuNaissance)
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    /**
     * Get lieuNaissance
     *
     * @return string
     */
    public function getLieuNaissance()
    {
        return $this->lieuNaissance;
    }

    /**
     * Set naturePiece
     *
     * @param string $naturePiece
     *
     * @return ParticulierLocataire
     */
    public function setNaturePiece($naturePiece)
    {
        $this->naturePiece = $naturePiece;

        return $this;
    }

    /**
     * Get naturePiece
     *
     * @return string
     */
    public function getNaturePiece()
    {
        return $this->naturePiece;
    }

    /**
     * Set numeroPiece
     *
     * @param string $numeroPiece
     *
     * @return ParticulierLocataire
     */
    public function setNumeroPiece($numeroPiece)
    {
        $this->numeroPiece = $numeroPiece;

        return $this;
    }

    /**
     * Get numeroPiece
     *
     * @return string
     */
    public function getNumeroPiece()
    {
        return $this->numeroPiece;
    }

    /**
     * Set dateDelivrance
     *
     * @param \DateTime $dateDelivrance
     *
     * @return ParticulierLocataire
     */
    public function setDateDelivrance($dateDelivrance)
    {
        $this->dateDelivrance = $dateDelivrance;

        return $this;
    }

    /**
     * Get dateDelivrance
     *
     * @return \DateTime
     */
    public function getDateDelivrance()
    {
        return $this->dateDelivrance;
    }

    /**
     * Set lieuDelivrance
     *
     * @param string $lieuDelivrance
     *
     * @return ParticulierLocataire
     */
    public function setLieuDelivrance($lieuDelivrance)
    {
        $this->lieuDelivrance = $lieuDelivrance;

        return $this;
    }

    /**
     * Get lieuDelivrance
     *
     * @return string
     */
    public function getLieuDelivrance()
    {
        return $this->lieuDelivrance;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return ParticulierLocataire
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set cellulaire
     *
     * @param string $cellulaire
     *
     * @return ParticulierLocataire
     */
    public function setCellulaire($cellulaire)
    {
        $this->cellulaire = $cellulaire;

        return $this;
    }

    /**
     * Get cellulaire
     *
     * @return string
     */
    public function getCellulaire()
    {
        return $this->cellulaire;
    }

    /**
     * Set nomSociete
     *
     * @param string $nomSociete
     *
     * @return ParticulierLocataire
     */
    public function setNomSociete($nomSociete)
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    /**
     * Get nomSociete
     *
     * @return string
     */
    public function getNomSociete()
    {
        return $this->nomSociete;
    }

    /**
     * Set profession
     *
     * @param string $profession
     *
     * @return ParticulierLocataire
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set telBureau
     *
     * @param string $telBureau
     *
     * @return ParticulierLocataire
     */
    public function setTelBureau($telBureau)
    {
        $this->telBureau = $telBureau;

        return $this;
    }

    /**
     * Get telBureau
     *
     * @return string
     */
    public function getTelBureau()
    {
        return $this->telBureau;
    }

    /**
     * Set adresseGeographique
     *
     * @param string $adresseGeographique
     *
     * @return ParticulierLocataire
     */
    public function setAdresseGeographique($adresseGeographique)
    {
        $this->adresseGeographique = $adresseGeographique;

        return $this;
    }

    /**
     * Get adresseGeographique
     *
     * @return string
     */
    public function getAdresseGeographique()
    {
        return $this->adresseGeographique;
    }

    /**
     * Set nomContactUrgence
     *
     * @param string $nomContactUrgence
     *
     * @return ParticulierLocataire
     */
    public function setNomContactUrgence($nomContactUrgence)
    {
        $this->nomContactUrgence = $nomContactUrgence;

        return $this;
    }

    /**
     * Get nomContactUrgence
     *
     * @return string
     */
    public function getNomContactUrgence()
    {
        return $this->nomContactUrgence;
    }

    /**
     * Set affiniteContactUrgence
     *
     * @param string $affiniteContactUrgence
     *
     * @return ParticulierLocataire
     */
    public function setAffiniteContactUrgence($affiniteContactUrgence)
    {
        $this->affiniteContactUrgence = $affiniteContactUrgence;

        return $this;
    }

    /**
     * Get affiniteContactUrgence
     *
     * @return string
     */
    public function getAffiniteContactUrgence()
    {
        return $this->affiniteContactUrgence;
    }

    /**
     * Set telContactUrgence
     *
     * @param string $telContactUrgence
     *
     * @return ParticulierLocataire
     */
    public function setTelContactUrgence($telContactUrgence)
    {
        $this->telContactUrgence = $telContactUrgence;

        return $this;
    }

    /**
     * Get telContactUrgence
     *
     * @return string
     */
    public function getTelContactUrgence()
    {
        return $this->telContactUrgence;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ParticulierLocataire
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
     * @return ParticulierLocataire
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
}
