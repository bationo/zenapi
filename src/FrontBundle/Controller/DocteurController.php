<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use AdminBundle\Entity\Message;
use UserBundle\Entity\User;
use AdminBundle\Form\Type\MessageType;
use AdminBundle\Entity\Ticket;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use FrontBundle\Form\Type\TicketType; 
use FrontBundle\Form\Type\AppSearchType; 
use AdminBundle\Entity\Newsletter;
use AdminBundle\Entity\Gallerie;
use AdminBundle\Entity\Rdv;
use AdminBundle\Entity\Modification;
use UserBundle\Form\Type\PatientType;
use UserBundle\Form\Type\PatientEditType;
use AdminBundle\Entity\Docteur; 
use AdminBundle\Entity\Disponible; 
use AdminBundle\Entity\Compte;
use AdminBundle\Form\Type\DocteurEditType;
use AdminBundle\Form\Type\DocteurType;
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
 * @Route("/docteur")
 */
class DocteurController extends Controller
{
	
	
	
    /**
     * @Route("/connexion", name="docteur_pro")
     */
    public function indexAction(Request $request)
    {
        
        if ($request->isMethod('POST')){
			
			
			$id = $request->request->get("id"); 
			$pass = $request->request->get("pass");
			
			$compte = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Compte')->findOneBy(array('id' => $id , 'pass' => $pass  ));
			
			if($compte){
				$docteur = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Docteur')->findOneBy(array('compte' => $compte->getId() , "remove" => false  ));
				
				if($docteur){
					$request->getSession()->set('docteur' , $docteur->getId());
				
				
				return $this->redirect($this->generateUrl('docteur_pro_connecter'  ) );
					
				}else{
					$request->getSession()->getFlashBag()->add('notice', 'information de connexion incorrecte ');
				}
				
				
			}else{
				
				$etat = $this->login($id , $pass);
				if ($etat == "false"){
					$request->getSession()->getFlashBag()->add('notice', 'information de connexion incorrecte ');
				}else{
					
			   $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findOneByUsername($id);
					
				$firewallName = $this->container->getParameter('fos_user.firewall_name');
				$token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, $user->getRoles());
				$this->get('security.token_storage')->setToken($token);
				$request->getSession()->set('_security_main', serialize($token));	
				
				return $this->redirect($this->generateUrl('homepro'  ) );
				}
				
				
				
				
				
			}
			
		}
			
		
		
        return $this->render('doc/index.html.twig', array(
           
        ));
    }
	
	/**
     * @Route("/compte", name="docteur_pro_connecter")
     */
    public function compteAction(Request $request)
    {
		if(!$this->connexion()){
			return $this->redirect($this->generateUrl('docteur_pro'  ) );
		}
		$em = $this->getDoctrine()->getManager();
		$docteur = $em->getRepository('AdminBundle:Docteur')->find($this->get('session')->get('docteur'));
		
		
			$rdvs = array();
			
			
				foreach($docteur->getRdv() as $rdv ){
					array_push($rdvs , $rdv);
				}
		
        
		if ($request->isMethod('POST')){
			$data = $request->request->get("rdv"); 
			
			if($data){
					$rdv = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Rdv')->find($data);
				if($rdv and $docteur->getId() == $rdv->getDocteur()->getId() ){
					 return $this->redirect($this->generateUrl('pro_rdv_show_pro' , array( "id" => $rdv->getId() ) ));
				}else{
					$request->getSession()->getFlashBag()->add('notice', 'aucun résultat trouvé');
				}
			}else{
				$start = $request->request->get("start"); 
				$end = $request->request->get("end");
					$start = new \DateTime($start);
					$end = new \DateTime($end);
					
				$liste = $this->getDoctrine()->getManager()->getRepository("AdminBundle:Rdv")->findrdvDocteur($start , $end , $docteur->getId() );
				
				
				return $this->render('doc/liste.html.twig', array( "docteur" => $docteur ,  "rdvs" => $liste , "start" => $start , "end" => $end
           
				));
			}
			
			
		}
		
		
        return $this->render('doc/rdv.html.twig', array( "rdvs" => $rdvs  , "docteur" => $docteur 
           
        ));
	}
	
	/**
     * @Route("/compte/profil", name="docteur_pro_profil")
     */
    public function profilAction()
    {
		if(!$this->connexion()){
			return $this->redirect($this->generateUrl('docteur_pro'  ) );
		}
		$docteur = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Docteur')->find($this->get('session')->get('docteur'));
		
		
		return $this->render('doc/profil.html.twig', array(
           "docteur" => $docteur
        ));
		
	}
	
	  /**
     * Edits an existing Docteur entity.
     *
     * @Route("/update", name="pro_docteur_update")
     */
    public function updateAction(Request $request)
    {
		
       if(!$this->connexion()){
			return $this->redirect($this->generateUrl('docteur_pro'  ) );
		}
		$em = $this->getDoctrine()->getManager();
		$docteur = $em->getRepository('AdminBundle:Docteur')->find($this->get('session')->get('docteur'));
		

	   $editForm = $this->createForm(DocteurType::class, $docteur, array(
            'action' => $this->generateUrl('pro_docteur_update'),
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
			$request->getSession()->getFlashBag()->add('notice', 'operation reussie');
            return $this->redirect($this->generateUrl('pro_docteur_update'));
        }

        
		
		return $this->render('doc/edit.html.twig', array(   'docteur' => $docteur,
            'edit_form'   => $editForm->createView(),
			));
    }
	
	/**
     * @Route("/initialise", name="specialite_initialise_docteur")
     */
    public function initialiseAction(Request $request)
    {
		 if(!$this->connexion()){
			return $this->redirect($this->generateUrl('docteur_pro'  ) );
		}

		$em = $this->getDoctrine()->getManager();
		$docteur = 	$em->getRepository('AdminBundle:Docteur')->find($this->get('session')->get('docteur'));
		
		
	   $pass = $this->generer_mot_de_passe();
	   $docteur->getCompte()->setPass($pass);
	   $em->flush();
			$request->getSession()->getFlashBag()->add('notice', 'Le compte à bien été initialisé ');
			return $this->redirect($this->generateUrl('docteur_pro_profil' ));
	   
		
	}
	
	/**
     * Finds and displays a Docteur entity.
     *
     * @Route("/disponible/docteur", name="docteur_disponible_pro")
     */
    public function disponibiliteAction(Request $request)
    {
        
		if(!$this->connexion()){
			return $this->redirect($this->generateUrl('docteur_pro'  ) );
		}
		$em = $this->getDoctrine()->getManager();
		$docteur = $em->getRepository('AdminBundle:Docteur')->find($this->get('session')->get('docteur'));
		
	   
        $form = $this->createForm(DocteurEditType::class, $docteur);
       
		 if ($form->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
			$request->getSession()->getFlashBag()->add('notice', 'operation reussie');        
			return $this->redirect($this->generateUrl('docteur_disponible_pro'));
        }

       
		
		return $this->render('doc/disponibile.html.twig', array(   'docteur' => $docteur , 'form'   => $form->createView(), ) );
    }
	
	/**
     * @Route("/patient", name="pro_patient_pro")
     */
    public function patientHomeAction()
    {
		
		if(!$this->connexion()){
			return $this->redirect($this->generateUrl('docteur_pro'  ) );
		}
		$em = $this->getDoctrine()->getManager();
		$docteur = $em->getRepository('AdminBundle:Docteur')->find($this->get('session')->get('docteur'));
			
        
        return $this->render('doc/patient_index.html.twig', array( "docteur" => $docteur 
           
        ));
    }
	
	/**
     * @Route("/patient/{id}/show", name="pro_patient_show_doc")
     */
    public function patientShowAction(User $user)
    {
		
		if(!$this->connexion()){
			return $this->redirect($this->generateUrl('docteur_pro'  ) );
		}
		$em = $this->getDoctrine()->getManager();
		$docteur = $em->getRepository('AdminBundle:Docteur')->find($this->get('session')->get('docteur'));
		
		
		  $etat = false;
		 
		
				foreach( $user->getProfil()->getRdv() as $rdv ){
					
					if($rdv->getDocteur()->getId() == $docteur->getId()   ){
						
						$etat = true;
						break;
					}
				}
		
		
		if($etat){
			return $this->render('doc/patient_show.html.twig', array( 'user'   => $user ,  'docteur'   => $docteur ) );
		}else{
			 return $this->redirect($this->generateUrl('docteur_pro'));
		}
		
			
        
       
    }

	
	
	/**
     * @Route("/deconnexion", name="docteur_pro_deconnexion")
     */
    public function deconnexionAction()
    {
		
		if(!$this->connexion()){
			return $this->redirect($this->generateUrl('docteur_pro'  ) );
		}
		
		$this->get('session')->remove('docteur'); 
		return $this->redirect($this->generateUrl('docteur_pro'  ) );
		
	}	
	
	/**
     * @Route("/show/{id}/rendez-vous", name="pro_rdv_show_pro")
     */
    public function afficherRdvAction(Rdv $rdv)
    {
		if(!$this->connexion()){
			return $this->redirect($this->generateUrl('docteur_pro'  ) );
		}
		$em = $this->getDoctrine()->getManager();
		$docteur = $em->getRepository('AdminBundle:Docteur')->find($this->get('session')->get('docteur'));
		
		
		if($docteur->getId() != $rdv->getDocteur()->getId()  ){
		   return $this->redirect($this->generateUrl('docteur_pro'));
	   }
		
		 return $this->render('doc/showRdv.html.twig', array(  "rdv" => $rdv , "docteur" => $docteur
           
        ));
	}
	
	
	/**
     * @Route("/liste/rendez-vous", name="pro_rdv_liste_doc")
     */
    public function rdvAction(Request $request)
    {
		
		if(!$this->connexion()){
			return $this->redirect($this->generateUrl('docteur_pro'  ) );
		}
		$em = $this->getDoctrine()->getManager();
		$docteur = $em->getRepository('AdminBundle:Docteur')->find($this->get('session')->get('docteur'));
		
		
			$rdvs = array();
			
			
				foreach($docteur->getRdv() as $rdv ){
					array_push($rdvs , $rdv);
				}
		
        
		if ($request->isMethod('POST')){
			$data = $request->request->get("rdv"); 
			
			if($data){
					$rdv = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Rdv')->find($data);
				if($rdv and $docteur->getId() == $rdv->getDocteur()->getId() ){
					 return $this->redirect($this->generateUrl('pro_rdv_show_pro' , array( "id" => $rdv->getId() ) ));
				}else{
					$request->getSession()->getFlashBag()->add('notice', 'aucun résultat trouvé');
				}
			}else{
				$start = $request->request->get("start"); 
				$end = $request->request->get("end");
					$start = new \DateTime($start);
					$end = new \DateTime($end);
					
				$liste = $this->getDoctrine()->getManager()->getRepository("AdminBundle:Rdv")->findrdvDocteur($start , $end , $docteur->getId() );
				
				
				return $this->render('doc/liste.html.twig', array( "docteur" => $docteur ,  "rdvs" => $liste , "start" => $start , "end" => $end
           
				));
			}
			
			
		}
		
		
        return $this->render('doc/rdv.html.twig', array( "rdvs" => $rdvs  , "docteur" => $docteur 
           
        ));
    }
	
	
	
	protected function connexion()
	{
		$docteur = $this->get('session')->get('docteur');
			if($docteur != null){
				return true;
			}else{
				
				return false;
			}
	}	
	
		protected function generer_mot_de_passe($nb_caractere = 6)
	{
			$mot_de_passe = "";
		   
			$chaine = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789+@!$%?&";
			$longeur_chaine = strlen($chaine);
		   
			for($i = 1; $i <= $nb_caractere; $i++)
			{
				$place_aleatoire = mt_rand(0,($longeur_chaine-1));
				$mot_de_passe .= $chaine[$place_aleatoire];
			}

			return $mot_de_passe;   
	}
    protected function login($username, $password)
	{
		$user_manager = $this->get('fos_user.user_manager');
		$factory = $this->get('security.encoder_factory');
		$user = $user_manager->loadUserByUsername($username);
		$encoder = $factory->getEncoder($user);
		$bool = ($encoder->isPasswordValid($user->getPassword() , $password, $user->getSalt())) ? "true" : "false";
		return $bool;
	}	
	
}
