<?php

namespace UserBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entreprise
 *
 * @ORM\Table(name="entreprise")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\EntrepriseRepository")
 */
class Entreprise
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
     * @ORM\Column(name="raisonSocial", type="string", length=255)
     */
    private $raisonSocial;
	
	
	/**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Proprietaire", inversedBy="entreprise" , cascade={"persist", "remove"})
	 *@ORM\JoinColumn(name="proprietaire_id", referencedColumnName="id")
     */
    private $proprietaire;
	
	

    /**
     * @var string
     *
     * @ORM\Column(name="formeJuridique", type="string", length=255)
     */
    private $formeJuridique;

    /**
     * @var string
     *
     * @ORM\Column(name="adressePostale", type="string", length=255, nullable=true)
     */
    private $adressePostale;

    /**
     * @var string
     *
     * @ORM\Column(name="siege", type="string", length=255)
     */
    private $siege;

    /**
     * @var string
     *
     * @ORM\Column(name="compteContribuable", type="string", length=255, nullable=true)
     */
    private $compteContribuable;

    /**
     * @var string
     *
     * @ORM\Column(name="registreCommerce", type="string", length=255, nullable=true)
     */
    private $registreCommerce;

    /**
     * @var string
     *
     * @ORM\Column(name="telBureau", type="string", length=255, nullable=true)
     */
    private $telBureau;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="gerantCivilite", type="string", length=255)
     */
    private $gerantCivilite;

    /**
     * @var string
     *
     * @ORM\Column(name="gerantNom", type="string", length=255)
     */
    private $gerantNom;

    /**
     * @var string
     *
     * @ORM\Column(name="gerantPrenom", type="string", length=255)
     */
    private $gerantPrenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="gerantDateNaissance", type="date" , nullable=true)
     */
    private $gerantDateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="gerantLieuNaissance", type="string", length=255 , nullable=true)
     */
    private $gerantLieuNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="gerantNaturePiece", type="string", length=255, nullable=true)
     */
    private $gerantNaturePiece;

    /**
     * @var string
     *
     * @ORM\Column(name="gerantNumeroPiece", type="string", length=255, nullable=true)
     */
    private $gerantNumeroPiece;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="gerantDateDelivrance", type="date" , nullable=true)
     */
    private $gerantDateDelivrance;

    /**
     * @var string
     *
     * @ORM\Column(name="gerantLieuDelivrance", type="string", length=255, nullable=true)
     */
    private $gerantLieuDelivrance;

    /**
     * @var string
     *
     * @ORM\Column(name="autre", type="string", length=255 , nullable=true)
     */
    private $autre;
	
	  /**
     * @var string
     *
     * @ORM\Column(name="gerantTelephone", type="string", length=255 , nullable=true)
     */
    private $gerantTelephone;
	

    /**
     * @var string
     *
     * @ORM\Column(name="gerantCellulaire", type="string", length=255 , nullable=true)
     */
    private $gerantCellulaire;

    /**
     * @var string
     *
     * @ORM\Column(name="gerantProfession", type="string", length=255, nullable=true)
     */
    private $gerantProfession;

    /**
     * @var string
     *
     * @ORM\Column(name="gerantMail", type="string", length=255, nullable=true)
     */
    private $gerantMail;

    /**
     * @var string
     *
     * @ORM\Column(name="gerantLieuHabitation", type="string", length=255)
     */
    private $gerantLieuHabitation;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

 

    /**
     * Set raisonSocial
     *
     * @param string $raisonSocial
     *
     * @return Entreprise
     */
    public function setRaisonSocial($raisonSocial)
    {
        $this->raisonSocial = $raisonSocial;

        return $this;
    }

    /**
     * Get raisonSocial
     *
     * @return string
     */
    public function getRaisonSocial()
    {
        return $this->raisonSocial;
    }

    /**
     * Set formeJuridique
     *
     * @param string $formeJuridique
     *
     * @return Entreprise
     */
    public function setFormeJuridique($formeJuridique)
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    /**
     * Get formeJuridique
     *
     * @return string
     */
    public function getFormeJuridique()
    {
        return $this->formeJuridique;
    }

    /**
     * Set adressePostale
     *
     * @param string $adressePostale
     *
     * @return Entreprise
     */
    public function setAdressePostale($adressePostale)
    {
        $this->adressePostale = $adressePostale;

        return $this;
    }

    /**
     * Get adressePostale
     *
     * @return string
     */
    public function getAdressePostale()
    {
        return $this->adressePostale;
    }

    /**
     * Set siege
     *
     * @param string $siege
     *
     * @return Entreprise
     */
    public function setSiege($siege)
    {
        $this->siege = $siege;

        return $this;
    }

    /**
     * Get siege
     *
     * @return string
     */
    public function getSiege()
    {
        return $this->siege;
    }

    /**
     * Set compteContribuable
     *
     * @param string $compteContribuable
     *
     * @return Entreprise
     */
    public function setCompteContribuable($compteContribuable)
    {
        $this->compteContribuable = $compteContribuable;

        return $this;
    }

    /**
     * Get compteContribuable
     *
     * @return string
     */
    public function getCompteContribuable()
    {
        return $this->compteContribuable;
    }

    /**
     * Set registreCommerce
     *
     * @param string $registreCommerce
     *
     * @return Entreprise
     */
    public function setRegistreCommerce($registreCommerce)
    {
        $this->registreCommerce = $registreCommerce;

        return $this;
    }

    /**
     * Get registreCommerce
     *
     * @return string
     */
    public function getRegistreCommerce()
    {
        return $this->registreCommerce;
    }

    /**
     * Set telBureau
     *
     * @param string $telBureau
     *
     * @return Entreprise
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
     * Set fax
     *
     * @param string $fax
     *
     * @return Entreprise
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set gerantCivilite
     *
     * @param string $gerantCivilite
     *
     * @return Entreprise
     */
    public function setGerantCivilite($gerantCivilite)
    {
        $this->gerantCivilite = $gerantCivilite;

        return $this;
    }

    /**
     * Get gerantCivilite
     *
     * @return string
     */
    public function getGerantCivilite()
    {
        return $this->gerantCivilite;
    }

    /**
     * Set gerantNom
     *
     * @param string $gerantNom
     *
     * @return Entreprise
     */
    public function setGerantNom($gerantNom)
    {
        $this->gerantNom = $gerantNom;

        return $this;
    }

    /**
     * Get gerantNom
     *
     * @return string
     */
    public function getGerantNom()
    {
        return $this->gerantNom;
    }

    /**
     * Set gerantPrenom
     *
     * @param string $gerantPrenom
     *
     * @return Entreprise
     */
    public function setGerantPrenom($gerantPrenom)
    {
        $this->gerantPrenom = $gerantPrenom;

        return $this;
    }

    /**
     * Get gerantPrenom
     *
     * @return string
     */
    public function getGerantPrenom()
    {
        return $this->gerantPrenom;
    }

    /**
     * Set gerantDateNaissance
     *
     * @param \DateTime $gerantDateNaissance
     *
     * @return Entreprise
     */
    public function setGerantDateNaissance($gerantDateNaissance)
    {
        $this->gerantDateNaissance = $gerantDateNaissance;

        return $this;
    }

    /**
     * Get gerantDateNaissance
     *
     * @return \DateTime
     */
    public function getGerantDateNaissance()
    {
        return $this->gerantDateNaissance;
    }

    /**
     * Set gerantLieuNaissance
     *
     * @param string $gerantLieuNaissance
     *
     * @return Entreprise
     */
    public function setGerantLieuNaissance($gerantLieuNaissance)
    {
        $this->gerantLieuNaissance = $gerantLieuNaissance;

        return $this;
    }

    /**
     * Get gerantLieuNaissance
     *
     * @return string
     */
    public function getGerantLieuNaissance()
    {
        return $this->gerantLieuNaissance;
    }

    /**
     * Set gerantNaturePiece
     *
     * @param string $gerantNaturePiece
     *
     * @return Entreprise
     */
    public function setGerantNaturePiece($gerantNaturePiece)
    {
        $this->gerantNaturePiece = $gerantNaturePiece;

        return $this;
    }

    /**
     * Get gerantNaturePiece
     *
     * @return string
     */
    public function getGerantNaturePiece()
    {
        return $this->gerantNaturePiece;
    }

    /**
     * Set gerantNumeroPiece
     *
     * @param string $gerantNumeroPiece
     *
     * @return Entreprise
     */
    public function setGerantNumeroPiece($gerantNumeroPiece)
    {
        $this->gerantNumeroPiece = $gerantNumeroPiece;

        return $this;
    }

    /**
     * Get gerantNumeroPiece
     *
     * @return string
     */
    public function getGerantNumeroPiece()
    {
        return $this->gerantNumeroPiece;
    }

    /**
     * Set gerantDateDelivrance
     *
     * @param \DateTime $gerantDateDelivrance
     *
     * @return Entreprise
     */
    public function setGerantDateDelivrance($gerantDateDelivrance)
    {
        $this->gerantDateDelivrance = $gerantDateDelivrance;

        return $this;
    }

    /**
     * Get gerantDateDelivrance
     *
     * @return \DateTime
     */
    public function getGerantDateDelivrance()
    {
        return $this->gerantDateDelivrance;
    }

    /**
     * Set gerantLieuDelivrance
     *
     * @param string $gerantLieuDelivrance
     *
     * @return Entreprise
     */
    public function setGerantLieuDelivrance($gerantLieuDelivrance)
    {
        $this->gerantLieuDelivrance = $gerantLieuDelivrance;

        return $this;
    }

    /**
     * Get gerantLieuDelivrance
     *
     * @return string
     */
    public function getGerantLieuDelivrance()
    {
        return $this->gerantLieuDelivrance;
    }

    /**
     * Set gerantTelephone
     *
     * @param string $gerantTelephone
     *
     * @return Entreprise
     */
    public function setGerantTelephone($gerantTelephone)
    {
        $this->gerantTelephone = $gerantTelephone;

        return $this;
    }

    /**
     * Get gerantTelephone
     *
     * @return string
     */
    public function getGerantTelephone()
    {
        return $this->gerantTelephone;
    }

    /**
     * Set gerantCellulaire
     *
     * @param string $gerantCellulaire
     *
     * @return Entreprise
     */
    public function setGerantCellulaire($gerantCellulaire)
    {
        $this->gerantCellulaire = $gerantCellulaire;

        return $this;
    }

    /**
     * Get gerantCellulaire
     *
     * @return string
     */
    public function getGerantCellulaire()
    {
        return $this->gerantCellulaire;
    }

    /**
     * Set gerantProfession
     *
     * @param string $gerantProfession
     *
     * @return Entreprise
     */
    public function setGerantProfession($gerantProfession)
    {
        $this->gerantProfession = $gerantProfession;

        return $this;
    }

    /**
     * Get gerantProfession
     *
     * @return string
     */
    public function getGerantProfession()
    {
        return $this->gerantProfession;
    }

    /**
     * Set gerantMail
     *
     * @param string $gerantMail
     *
     * @return Entreprise
     */
    public function setGerantMail($gerantMail)
    {
        $this->gerantMail = $gerantMail;

        return $this;
    }

    /**
     * Get gerantMail
     *
     * @return string
     */
    public function getGerantMail()
    {
        return $this->gerantMail;
    }

    /**
     * Set gerantLieuHabitation
     *
     * @param string $gerantLieuHabitation
     *
     * @return Entreprise
     */
    public function setGerantLieuHabitation($gerantLieuHabitation)
    {
        $this->gerantLieuHabitation = $gerantLieuHabitation;

        return $this;
    }

    /**
     * Get gerantLieuHabitation
     *
     * @return string
     */
    public function getGerantLieuHabitation()
    {
        return $this->gerantLieuHabitation;
    }

    /**
     * Set nomContactUrgence
     *
     * @param string $nomContactUrgence
     *
     * @return Entreprise
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
     * @return Entreprise
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
     * @return Entreprise
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
     * @return Entreprise
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
     * @return Entreprise
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
     * Set proprietaire
     *
     * @param \UserBundle\Entity\Proprietaire $proprietaire
     *
     * @return Entreprise
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
     * Set autre
     *
     * @param string $autre
     *
     * @return Entreprise
     */
    public function setAutre($autre)
    {
        $this->autre = $autre;

        return $this;
    }

    /**
     * Get autre
     *
     * @return string
     */
    public function getAutre()
    {
        return $this->autre;
    }
}
