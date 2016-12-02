<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use AdminBundle\Entity\Contact;
use UserBundle\Entity\User;
use UserBundle\Form\Type\ProfessionelEditType; 
use UserBundle\Form\Type\PasswordType;
use AdminBundle\Form\Type\NewsletterType;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Comment controller.
 *
 * @Route("/pro/message")
 */
class ContactController extends Controller
{
	
	
	
	
    /**
     * @Route("/", name="contact_pro")
     */
    public function indexAction()
    {
		
		$contact = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Contact')->findBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));
		
        	
        return $this->render('contact/index.html.twig', array( "contacts" => $contact
           
        ));
    }
	
	/**
     * @Route("/{id}/show/", name="contact_show_pro")
     */
    public function showAction(Contact $contact)
    {
		
		if( $this->getUser()->getProfessionnel()->getId() != $contact->getProfessionnel()->getId()  ){
		   return $this->redirect($this->generateUrl('repertoire'));
	   }
	   
	   if( $contact->getStatut() == false ){
		   $contact->setStatut(true);
			$this->getDoctrine()->getManager()->flush();
	   }
		
        	
        return $this->render('contact/show.html.twig', array( "contact" => $contact
           
        ));
    }
	
	/**
     * @Route("/ajax", name="contact_ajax_pro")
     */
    public function ajaxAction()
    {
		
	$contact = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Contact')->findBy(array( "statut" => false, 'professionnel' => $this->getUser()->getProfessionnel() ));

		
        	
        return $this->render('contact/count.html.twig', array( "contact" => $contact
           
        ));
    }
	
}
