<?php

namespace GeranceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FactContrat
 *
 * @ORM\Table(name="fact_contrat")
 * @ORM\Entity(repositoryClass="GeranceBundle\Repository\FactContratRepository")
 */
class FactContrat
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
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;
	
	/**
   * @ORM\OneToOne(targetEntity="GeranceBundle\Entity\Facture", cascade={"persist"})
   * @ORM\JoinColumn( nullable=false)
   */
   private $facture;
   
	
    /**
     * @var int
     *
     * @ORM\Column(name="caution", type="integer")
     */
    private $caution;



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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return FactContrat
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
     * @return FactContrat
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
     * Set montant
     *
     * @param integer $montant
     *
     * @return FactContrat
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return integer
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set caution
     *
     * @param integer $caution
     *
     * @return FactContrat
     */
    public function setCaution($caution)
    {
        $this->caution = $caution;

        return $this;
    }

    /**
     * Get caution
     *
     * @return integer
     */
    public function getCaution()
    {
        return $this->caution;
    }


    /**
     * Set facture
     *
     * @param \GeranceBundle\Entity\Facture $facture
     *
     * @return FactContrat
     */
    public function setFacture(\GeranceBundle\Entity\Facture $facture)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \GeranceBundle\Entity\Facture
     */
    public function getFacture()
    {
        return $this->facture;
    }
}
