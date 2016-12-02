<?php

namespace AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\MessageRepository")
  * @ORM\HasLifecycleCallbacks
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
	 * @Gedmo\Timestampable(on="create")
     */
    private $created;
	
	/**
   * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Ticket",  inversedBy="message" , cascade={"persist"} )
   * @ORM\JoinColumn(nullable=false)
   */
    private $ticket;
	
	/**
     * @ORM\OneToOne(targetEntity="AdminBundle\Entity\Image", cascade={"persist", "remove"})
     * @Assert\Valid
     */

    private $image;
	
	  /**
     * Set image
     *
     * @param \AdminBundle\Entity\Image $image
     *
     * @return Docteur
     */
    public function setImage(\AdminBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AdminBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }	
		
		
		
	/**
   * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",  inversedBy="message" , cascade={"persist"} )
   * @ORM\JoinColumn(nullable=false)
   */
    private $user;


	

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Message
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Message
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
     * Set ticket
     *
     * @param \AdminBundle\Entity\Ticket $ticket
     *
     * @return Message
     */
    public function setTicket(\AdminBundle\Entity\Ticket $ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \AdminBundle\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Message
     */
    public function setUser(\UserBundle\Entity\User $user)
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
	

}
