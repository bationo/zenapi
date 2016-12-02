<?php

namespace GeranceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OptionPaiement
 *
 * @ORM\Table(name="option_paiement")
 * @ORM\Entity(repositoryClass="GeranceBundle\Repository\OptionPaiementRepository")
 */
class OptionPaiement
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
     * @var int
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity="GeranceBundle\Entity\Facture", inversedBy="optionPaiement")
     * @ORM\JoinColumn(name="facture_id", referencedColumnName="id", nullable=false)
     */
    private $facture;


    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;


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
     * @return OptionPaiement
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
     * Set montant
     *
     * @param integer $montant
     *
     * @return OptionPaiement
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
     * Set reference
     *
     * @param string $reference
     *
     * @return OptionPaiement
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
     * Set facture
     *
     * @param \GeranceBundle\Entity\Facture $facture
     *
     * @return OptionPaiement
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
