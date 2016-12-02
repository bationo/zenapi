<?php

namespace GeranceBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Locative
 *
 * @ORM\Table(name="locative")
 * @ORM\Entity(repositoryClass="GeranceBundle\Repository\LocativeRepository")
 */
class Locative
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
     * @ORM\ManyToOne(targetEntity="GeranceBundle\Entity\Immobilier", inversedBy="locative")
     * @ORM\JoinColumn(name="immobilier_id", referencedColumnName="id", nullable=false)
     */
    private $immobilier; 

	/**
	 * @ORM\OneToMany(targetEntity="GeranceBundle\Entity\Contrat", mappedBy="locative" , cascade={"persist","remove"})
	 */
	 private $contrat;
	

   

    /**
     * @var string
     *
     * @ORM\Column(name="porte", type="string", length=255)
     */
    private $porte;

    /**
     * @var integer
     *
     * @ORM\Column(name="loyer", type="integer")
     */
    private $loyer;
	
	 /**
     * @var boolean
     *
     * @ORM\Column(name="meuble", type="boolean")
     */
    private $meuble;

    /**
     * @var int
     *
     * @ORM\Column(name="charge", type="integer")
     */
    private $charge;

    /**
     * @var integer
     *
     * @ORM\Column(name="piece", type="integer")
     */
    private $piece;

    /**
     * @var string
     *
     * @ORM\Column(name="supercie",  type="string", length=255)
     */
    private $supercie;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

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
     * @return Locative
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
     * Set porte
     *
     * @param string $porte
     *
     * @return Locative
     */
    public function setPorte($porte)
    {
        $this->porte = $porte;

        return $this;
    }

    /**
     * Get porte
     *
     * @return string
     */
    public function getPorte()
    {
        return $this->porte;
    }

    /**
     * Set loyer
     *
     * @param string $loyer
     *
     * @return Locative
     */
    public function setLoyer($loyer)
    {
        $this->loyer = $loyer;

        return $this;
    }

    /**
     * Get loyer
     *
     * @return string
     */
    public function getLoyer()
    {
        return $this->loyer;
    }

    /**
     * Set charge
     *
     * @param integer $charge
     *
     * @return Locative
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * Get charge
     *
     * @return int
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * Set piece
     *
     * @param string $piece
     *
     * @return Locative
     */
    public function setPiece($piece)
    {
        $this->piece = $piece;

        return $this;
    }

    /**
     * Get piece
     *
     * @return string
     */
    public function getPiece()
    {
        return $this->piece;
    }

    /**
     * Set supercie
     *
     * @param integer $supercie
     *
     * @return Locative
     */
    public function setSupercie($supercie)
    {
        $this->supercie = $supercie;

        return $this;
    }

    /**
     * Get supercie
     *
     * @return int
     */
    public function getSupercie()
    {
        return $this->supercie;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Locative
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Locative
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
     * @return Locative
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
     * Set immobilier
     *
     * @param \GeranceBundle\Entity\Immobilier $immobilier
     *
     * @return Locative
     */
    public function setImmobilier(\GeranceBundle\Entity\Immobilier $immobilier)
    {
        $this->immobilier = $immobilier;

        return $this;
    }

    /**
     * Get immobilier
     *
     * @return \GeranceBundle\Entity\Immobilier
     */
    public function getImmobilier()
    {
        return $this->immobilier;
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
     * @return Locative
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
     * Set meuble
     *
     * @param boolean $meuble
     *
     * @return Locative
     */
    public function setMeuble($meuble)
    {
        $this->meuble = $meuble;

        return $this;
    }

    /**
     * Get meuble
     *
     * @return boolean
     */
    public function getMeuble()
    {
        return $this->meuble;
    }
}
