<?php

namespace AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * ComptePro
 *
 * @ORM\Table(name="compte_pro")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CompteProRepository")
 */
class ComptePro
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
     * @ORM\Column(name="nb", type="integer")
     */
    private $nb;
	


    /**
     * @var string
     *
     * @ORM\Column(name="sender", type="string", length=255 , nullable=true)
     */
    private $sender;

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
     * Set nb
     *
     * @param integer $nb
     *
     * @return ComptePro
     */
    public function setNb($nb)
    {
        $this->nb = $nb;

        return $this;
    }

    /**
     * Get nb
     *
     * @return int
     */
    public function getNb()
    {
        return $this->nb;
    }

    /**
     * Set sender
     *
     * @param string $sender
     *
     * @return ComptePro
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ComptePro
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
     * @return ComptePro
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
