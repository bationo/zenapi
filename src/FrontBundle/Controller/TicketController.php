<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use AdminBundle\Form\Type\TicketType;
use AdminBundle\Entity\Ticket;
use AdminBundle\Form\Type\MessageType;
use AdminBundle\Form\Type\MessageeType;
use AdminBundle\Entity\Message;
use Doctrine\ORM\QueryBuilder;

/**
 * Ticket controller.
 *
 * @Route("/pro/ticket")
 */
class TicketController extends Controller
{
    /**
     * Lists all Ticket entities.
     *
     * @Route("/", name="ticket_pro")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {

		 $ticket = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Ticket')->findBy( array( "user" =>$this->getUser() )  );
		
        return $this->render('Ticket/index.html.twig', array(
		"ticket" => $ticket
           
        ));
    }
	
	/**
     * Lists all Ticket entities.
     *
     * @Route("/ticket/new", name="new_ticket")
     * @Template()
     */
    public function newAction(Request $request)
    {
		
		
		
		$ticket = new Ticket();
		
        $form = $this->createForm( TicketType::class , $ticket , array( 'id' => $this->getUser()->getId() ) );
		
		 
        if($form->handleRequest($request)->isValid()) {
		
		
			$ticket->setUser( $this->getUser() );
			$ticket->setStatut(true);
			
			
			
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
			$em->refresh($ticket);
			
			
			return $this->redirect($this->generateUrl('ticket_show' , array('id' => $ticket->getId() ) ));
           
        }

        
		
		
        return $this->render('Ticket/new.html.twig', array(
           'form'   => $form->createView()
        ));
    }

	
	 /**
     * Finds and displays a Domaine entity.
     *
     * @Route("/{id}/show", name="ticket_show", requirements={"id"="\d+"})
     * @Template()
     */
    public function showAction( $id , Request $request)
    {
		
		$em = $this->getDoctrine()->getManager();
		$ticket =  $em->getRepository('AdminBundle:Ticket')->find($id);
		
		
	
	
       if(! $ticket->getUser()->getId() == $this->getUser()->getId() ){
		   return $this->redirect($this->generateUrl('compte_index'));
	   }
	   
	   
		$message = new Message();
		
        $form = $this->createForm( MessageeType::class, $message);
		
		
		 
        if($form->handleRequest($request)->isValid()) {
			
		
			$ticket->setStatut(true);
			$em->flush();
			$em->refresh($ticket);
			$emm = $this->getDoctrine()->getManager();
			$message->setUser($this->getUser());
			$message->setTicket($ticket);
			
			
			
			
           
            $emm->persist($message);
            $emm->flush();
			 return $this->redirect($this->generateUrl('ticket_show' , array('id' => $ticket->getId() ) ));
           
        }
	   
	   
	   
	   
	   
	   
	   
		return $this->render('Ticket/show.html.twig', array(
          'ticket' => $ticket,
		  'form'   => $form->createView(),
        ));
    }
}
