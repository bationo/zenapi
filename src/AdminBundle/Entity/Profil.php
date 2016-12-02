<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Profil
 *
 * @ORM\Table(name="profils")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ProfilRepository")
 */
class Profil
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
     * @ORM\Column(name="nom", type="string", length=225  )
     */
    private $nom;
	
	
	
	/**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="profil" , cascade={"persist", "remove"})
	 *@ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
	

	 
	 
	 
	
	
	/**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=225  )
	 */
    private $tel;
	
	/**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=225  )
	 */
    private $genre;
	

	
	/**
    * @var string
    *
    * @ORM\Column(name="prenom", type="string", length=225  )
     */
    private $prenom;
	
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date" )
     */
    private $dateNaissance;
	
	/**
     * @var string
     *
     * @ORM\Column(name="lieuNaissance", type="string", length=255 )
     */
    private $lieuNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="groupeSanguin", type="string", length=255 , nullable=true )
     */
    private $groupeSanguin;
	
	    /**
     * @var boolean
     *
     * @ORM\Column(name="assurer", type="boolean" , nullable=true )
     */
    private $assurer;

    /**
     * @var string
     *
     * @ORM\Column(name="CompagnieAssurance", type="string", length=255 , nullable=true )
     */
    private $compagnieAssurance;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroAssurance", type="string", length=255 , nullable=true  )
     */
    private $numeroAssurance;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text" , nullable=true )
     */
    private $note;
	
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Profil
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
     * Set tel
     *
     * @param string $tel
     *
     * @return Profil
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Profil
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
     * @param \DateTime $dateNaissance
     *
     * @return Profil
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
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
     * @return Profil
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
     * Set ville
     *
     * @param string $ville
     *
     * @return Profil
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set groupeSanguin
     *
     * @param string $groupeSanguin
     *
     * @return Profil
     */
    public function setGroupeSanguin($groupeSanguin)
    {
        $this->groupeSanguin = $groupeSanguin;

        return $this;
    }

    /**
     * Get groupeSanguin
     *
     * @return string
     */
    public function getGroupeSanguin()
    {
        return $this->groupeSanguin;
    }

    /**
     * Set assurer
     *
     * @param boolean $assurer
     *
     * @return Profil
     */
    public function setAssurer($assurer)
    {
        $this->assurer = $assurer;

        return $this;
    }

    /**
     * Get assurer
     *
     * @return boolean
     */
    public function getAssurer()
    {
        return $this->assurer;
    }

    /**
     * Set compagnieAssurance
     *
     * @param string $compagnieAssurance
     *
     * @return Profil
     */
    public function setCompagnieAssurance($compagnieAssurance)
    {
        $this->compagnieAssurance = $compagnieAssurance;

        return $this;
    }

    /**
     * Get compagnieAssurance
     *
     * @return string
     */
    public function getCompagnieAssurance()
    {
        return $this->compagnieAssurance;
    }

    /**
     * Set numeroAssurance
     *
     * @param string $numeroAssurance
     *
     * @return Profil
     */
    public function setNumeroAssurance($numeroAssurance)
    {
        $this->numeroAssurance = $numeroAssurance;

        return $this;
    }

    /**
     * Get numeroAssurance
     *
     * @return string
     */
    public function getNumeroAssurance()
    {
        return $this->numeroAssurance;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Profil
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Profil
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
     * @return Profil
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
     * @return Profil
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
     * Set genre
     *
     * @param string $genre
     *
     * @return Profil
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }
}
