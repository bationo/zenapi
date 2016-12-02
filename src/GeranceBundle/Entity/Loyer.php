<?php

namespace GeranceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Loyer
 *
 * @ORM\Table(name="loyer")
 * @ORM\Entity(repositoryClass="GeranceBundle\Repository\LoyerRepository")
 */
class Loyer
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
     * @var int
     *
     * @ORM\Column(name="nbMois", type="integer")
     */
    private $nbMois;
	
	/**
     * @ORM\OneToMany(targetEntity="GeranceBundle\Entity\Facture", mappedBy="loyer" , cascade={"persist","remove"})
     */
    private $facture;
	
	 /**
     * @ORM\ManyToOne(targetEntity="GeranceBundle\Entity\Contrat", inversedBy="loyer")
     * @ORM\JoinColumn(name="contrat_id", referencedColumnName="id", nullable=false)
     */
    private $contrat;
	
	

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="datetime")
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="datetime")
     */
    private $fin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime")
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
     * Set nbMois
     *
     * @param integer $nbMois
     *
     * @return Loyer
     */
    public function setNbMois($nbMois)
    {
        $this->nbMois = $nbMois;

        return $this;
    }

    /**
     * Get nbMois
     *
     * @return int
     */
    public function getNbMois()
    {
        return $this->nbMois;
    }

    /**
     * Set montant
     *
     * @param integer $montant
     *
     * @return Loyer
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return int
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set debut
     *
     * @param \DateTime $debut
     *
     * @return Loyer
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     *
     * @return Loyer
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Loyer
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
     * @return Loyer
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
     * Constructor
     */
    public function __construct()
    {
        $this->facture = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add facture
     *
     * @param \GeranceBundle\Entity\Facture $facture
     *
     * @return Loyer
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

    /**
     * Set contrat
     *
     * @param \GeranceBundle\Entity\Contrat $contrat
     *
     * @return Loyer
     */
    public function setContrat(\GeranceBundle\Entity\Contrat $contrat)
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * Get contrat
     *
     * @return \GeranceBundle\Entity\Contrat
     */
    public function getContrat()
    {
        return $this->contrat;
    }
}
