<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AdminBundle\Entity\Repertoire;
use AdminBundle\Entity\ComptePro;
use AdminBundle\Entity\CompteFree;
use AdminBundle\Entity\HistMessage;
use AdminBundle\Form\Type\RepertoireType;

/**
 * Repertoire controller.
 *
 * @Route("/pro/repertoire")
 */
class RepertoireController extends Controller
{
    /**
     * Lists all Repertoire entities.
     *
     * @Route("/", name="repertoire")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Repertoire')->findAll();
		
		 
		 $docteur = $em->getRepository('AdminBundle:Docteur')->findBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));
		 $user = $em->getRepository('AdminBundle:Profil')->findBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));
        
     
		return $this->render('repertoire/index.html.twig', array( "docteurs" => $docteur , "users" => $user,    'entities'   => $entities ));
    }
	
	
		/**
     * Lists all Repertoire entities.
     *
     * @Route("/affichage/{id}/message", name="repertoire_affichage")
     * @Template()
     */
    public function affichageAction(HistMessage $message)
    {
		
		if($this->getUser()->getId() != $message->getUser()->getId()  ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }
	   
	   	$dateO = new \DateTime();  $dateM = $message->getDateEnvoie();
		
		if($dateM > $dateO ){
			
			$periode = $dateM->diff($dateO);
			$minutes = $periode->days * 24 * 60;
			$minutes += $periode->h * 60;
			$minutes += $periode->i;
			
		}else{
			$minutes = 0;
		}
		
		
		return $this->render('repertoire/affichage.html.twig', array( "message" => $message , "minutes" => $minutes  ));
	}
	
	/**
     * Lists all Repertoire entities.
     *
     * @Route("/all/{type}/message", name="repertoire_all")
     * @Template()
     */
    public function listeAction($type)
    {
		
		
		$message = $this->getDoctrine()->getManager()->getRepository('AdminBundle:HistMessage')->findBy(array( 'user' => $this->getUser() , "type" => $type ));
		
		return $this->render('repertoire/all.html.twig', array( "messages" => $message   ));
	}
	
	/**
     * @Route("/envoie/annuler/{id}/message", name="pro_message_annuler")
     */
    public function annulerAction(HistMessage $message , Request $request)
    {
		if($this->getUser()->getId() != $message->getUser()->getId() or $message->getStatut() != 0 ){
		   return $this->redirect($this->generateUrl('repertoire'));
	   }
	   
			$em = $this->getDoctrine()->getManager();
		if($message->getType() == "sms"){	
			if($message->getCompte() == "Pro"){
				$compteSMS = $em->getRepository('AdminBundle:ComptePro')->findOneBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));
	
						}else{
			$compteSMS = $em->getRepository('AdminBundle:CompteFree')->findOneBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));

						}
			
				
			$nb =  $compteSMS->getNb() + count($message->getName());
			
			if($message->getCompte() == "Free"){
				
				if($nb > 10 ){
					$nb = 10 ;
				}
				
			}
			
			$compteSMS->setNb($nb);
			
	}	
			
			$message->setStatut(2);
			$em->flush();
			$request->getSession()->getFlashBag()->add('notice', 'Le Message a bien été  annulé !');
			return $this->redirect($this->generateUrl('repertoire_affichage' , array( "id" => $message->getId() ) ));
		
	}
	
	/**
     * Lists all Repertoire entities.
     *
     * @Route("/editt/{id}/message", name="repertoire_edit_edit")
     * @Template()
     */
    public function edittAction(HistMessage $message , Request $request)
    {
		
		if($this->getUser()->getId() != $message->getUser()->getId()  ){
		   return $this->redirect($this->generateUrl('repertoire'));
	   }
	   
	   	$dateO = new \DateTime();  $dateM = $message->getDateEnvoie();
		
		
		if($dateM > $dateO ){
			
			$periode = $dateM->diff($dateO);
			$minutes = $periode->days * 24 * 60;
			$minutes += $periode->h * 60;
			$minutes += $periode->i;
			
		}else{
			$minutes = 0;
		}
		if($minutes < 30 ){
			return $this->redirect($this->generateUrl('repertoire_affichage' , array("id" => $message->getId() ) ));
		}
		
		
		if($request->isMethod('POST')){
			if($minutes < 30 ){
				echo 1;
			}else{
				
				$titre = $request->request->get("titre");
				$msg = $request->request->get("msg");
				$option = $request->request->get("option");
				$heure = $request->request->get("heure");
				$minute = $request->request->get("minute");
				$date = $request->request->get("date");
				
				if($option == 1){
							$dateEnvoie =	new \DateTime($date.' '.$heure.':'.$minute);
					
						}else{
							$dateEnvoie =	new \DateTime();
							$dateEnvoie->modify("+2 minutes");
						}
						
						$message->setTitre($titre);
						$message->setMessage($msg);
						$message->setDateEnvoie($dateEnvoie);
						$this->getDoctrine()->getManager()->flush();
						echo 2;
			}
			
			die();
		}
		
		
		return $this->render('repertoire/editt.html.twig', array( "message" => $message , "minutes" => $minutes  ));
	}
	
	
	
	/**
     * Lists all Repertoire entities.
     *
     * @Route("/envoie/repertoire", name="repertoire_envoie")
     * @Template()
     */
    public function envoieAction(Request $request)
    {
		
		if ($request->isMethod('POST')){
			
			$send = $request->request->get("send");
			if($send){
				
				$mails = $request->request->get("mails"); 
				$tels = $request->request->get("tels");
				$names = $request->request->get("names");
				$type = $request->request->get("type");
				$titre = $request->request->get("titre");
				$msg = $request->request->get("msg");
				$option = $request->request->get("option");
				$heure = $request->request->get("heure");
				$minute = $request->request->get("minute");
				$date = $request->request->get("date");
				$compte = $request->request->get("compte");
				$em = $this->getDoctrine()->getManager();
				
				if($type == "sms"){
					if($compte == "Pro"){
				$compteSMS = $em->getRepository('AdminBundle:ComptePro')->findOneBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));
	
						}else{
			$compteSMS = $em->getRepository('AdminBundle:CompteFree')->findOneBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));

						}
					
					$contactTel = array();
					$name = array();
					$nbContact = explode("--",$tels);
					$nbname = explode("--",$names);
					foreach($nbContact as $key => $elem){
						if($elem != "" ){
							$contactTel[] = $elem;
							$name[] = $nbname[$key];
						}
					}
					if( $compteSMS->getNb() >= count($contactTel) ){
						
						
						if($option == 1){
							$dateEnvoie =	new \DateTime($date.' '.$heure.':'.$minute);
					
						}else{
							$dateEnvoie =	new \DateTime();
							$dateEnvoie->modify("+2 minutes");
						}
						$message = new HistMessage();
						$message->setTitre($titre);
						$message->setMessage($msg);
						$message->setTel($contactTel); 
						$message->setCompte($compte);
						$message->setName($name);
						$message->setType($type);
						$message->setStatut(0);
						$message->setDateEnvoie($dateEnvoie);
						$message->setUser($this->getUser());
						$nb =  $compteSMS->getNb() - count($contactTel);
						$compteSMS->setNb($nb);
						$em->persist($message);
						$em->flush();
						$em->refresh($message);
						
						echo $message->getId();
						
						
					}else{
						echo 10;
					}
					
					
				}
				
				if($type == "mail"){
					
					$contactMail = array();
					$name = array();
					$nbContact = explode("--",$mails);
					$nbname = explode("--",$names);
					foreach($nbContact as $key => $elem){
						if($elem != "" ){
							$contactMail[] = $elem;
							$name[] = $nbname[$key];
						}
					}
						
						if($option == 1){
							$dateEnvoie =	new \DateTime($date.' '.$heure.':'.$minute);
					
						}else{
							$dateEnvoie =	new \DateTime();
							$dateEnvoie->modify("+2 minutes");
						}
						$message = new HistMessage();
						$message->setTitre($titre);
						$message->setMessage($msg);
						$message->setCompte($compte);
						$message->setMail($contactMail);
						$message->setName($name);
						$message->setType($type);
						$message->setStatut(0);
						$message->setDateEnvoie($dateEnvoie);
						$message->setUser($this->getUser());
						$em->persist($message);
						$em->flush();
						$em->refresh($message);
						
						echo $message->getId();
						
						
					
					
					
				}
				
				


				die();
			}else{
				
				$mails = $request->request->get("mails"); 
				$tels = $request->request->get("tels");
				$names = $request->request->get("names");
				$type = $request->request->get("type");
					return $this->render('repertoire/envoie.html.twig', array( "mails" => $mails , "tels" => $tels,    'names'   => $names , "type" => $type  ));

				
			}
			
			
			
			
			
		}else{
			return $this->redirect($this->generateUrl('repertoire'));
		}
		
		
        
     
		
    }
	
	/**
     * Lists all Repertoire entities.
     *
     * @Route("/compte/compte", name="repertoire_compte")
     * @Template()
     */
    public function compteAction(Request $request)
    {
		$comptePro = null;
		$compteFree = null;
		$Pro = $this->getDoctrine()->getManager()->getRepository('AdminBundle:ComptePro')->findOneBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));
		$Free = $this->getDoctrine()->getManager()->getRepository('AdminBundle:CompteFree')->findOneBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));
	    $sms = $this->getDoctrine()->getManager()->getRepository('AdminBundle:HistMessage')->findBy(array( 'user' => $this->getUser() , "type" => "sms" ));
		$mail = $this->getDoctrine()->getManager()->getRepository('AdminBundle:HistMessage')->findBy(array( 'user' => $this->getUser() , "type" => "mail" ));
		
		if($Pro != null ){
			$comptePro = $Pro;
			
		}else{
			$comptePro = new ComptePro();
			$comptePro->setNb(0);
			$comptePro->setProfessionnel($this->getUser()->getProfessionnel());
			$em = $this->getDoctrine()->getManager();
			$em->persist($comptePro);
			$em->flush();
			$em->refresh($comptePro);
			
		}
		if($Free != null ){
			$compteFree = $Free;
			
		}else{
			$compteFree = new CompteFree();
			$compteFree->setNb(0);
			$compteFree->setProfessionnel($this->getUser()->getProfessionnel());
			$em = $this->getDoctrine()->getManager();
			$em->persist($compteFree);
			$em->flush();
			$em->refresh($compteFree);
			
		}
		$nbSMS = 0;
		foreach($sms as $elem){
			
			$nbSMS = $nbSMS + count($elem->getName());
		}
		$nbMail = 0;
		foreach($mail as $elem){
			
			$nbMail = $nbMail + count($elem->getName());
		}
		
	
			
			
		return $this->render('repertoire/compte.html.twig', array( "nbSMS" => $nbSMS , "nbMail" => $nbMail ,  "comptePro" => $comptePro ,  "compteFree" => $compteFree ));
		
		
    }

    /**
     * Finds and displays a Repertoire entity.
     *
     * @Route("/{id}/show", name="repertoire_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Repertoire $repertoire)
    {
        $deleteForm = $this->createDeleteForm($repertoire->getId(), 'repertoire_delete');

      
		return $this->render('repertoire/show.html.twig', array(   'repertoire' => $repertoire,
            'delete_form' => $deleteForm->createView(), ));
    }

    /**
     * Displays a form to create a new Repertoire entity.
     *
     * @Route("/new", name="repertoire_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $repertoire = new Repertoire();
        $form = $this->createForm( RepertoireType::class, $repertoire);

     
		return $this->render('repertoire/new.html.twig', array(    'repertoire' => $repertoire,
            'form'   => $form->createView(), ));
    }

    /**
     * Creates a new Repertoire entity.
     *
     * @Route("/create", name="repertoire_create")
     * @Method("POST")
     * @Template("AdminBundle:Repertoire:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $repertoire = new Repertoire();
        $form = $this->createForm( RepertoireType::class, $repertoire);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
			$repertoire->setProfessionnel($this->getUser()->getProfessionnel());
            $em->persist($repertoire);
            $em->flush();

            return $this->redirect($this->generateUrl('repertoire_show', array('id' => $repertoire->getId())));
        }

      
		return $this->render('repertoire/new.html.twig', array(    'repertoire' => $repertoire,
            'form'   => $form->createView(), ));
    }

    /**
     * Displays a form to edit an existing Repertoire entity.
     *
     * @Route("/{id}/edit", name="repertoire_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Repertoire $repertoire)
    {
        $editForm = $this->createForm( RepertoireType::class, $repertoire, array(
            'action' => $this->generateUrl('repertoire_update', array('id' => $repertoire->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($repertoire->getId(), 'repertoire_delete');

     
		return $this->render('repertoire/edit.html.twig', array(   'repertoire' => $repertoire,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(), ));
    }

    /**
     * Edits an existing Repertoire entity.
     *
     * @Route("/{id}/update", name="repertoire_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AdminBundle:Repertoire:edit.html.twig")
     */
    public function updateAction(Repertoire $repertoire, Request $request)
    {
        $editForm = $this->createForm( RepertoireType::class, $repertoire, array(
            'action' => $this->generateUrl('repertoire_update', array('id' => $repertoire->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
			$request->getSession()->getFlashBag()->add('notice', 'operation reussie'); 
            return $this->redirect($this->generateUrl('repertoire_edit', array('id' => $repertoire->getId())));
        }
        $deleteForm = $this->createDeleteForm($repertoire->getId(), 'repertoire_delete');

      
		return $this->render('repertoire/edit.html.twig', array(   'repertoire' => $repertoire,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(), ));
    }

    /**
     * Deletes a Repertoire entity.
     *
     * @Route("/{id}/delete", name="repertoire_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Repertoire $repertoire, Request $request)
    {
        $form = $this->createDeleteForm($repertoire->getId(), 'repertoire_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($repertoire);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('repertoire'));
    }

    /**
     * Create Delete form
     *
     * @param integer                       $id
     * @param string                        $route
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => 'delete')))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
