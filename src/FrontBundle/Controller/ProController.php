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
use FrontBundle\Form\Type\TicketType; 
use FrontBundle\Form\Type\AppSearchType; 
use AdminBundle\Entity\Newsletter;
use AdminBundle\Entity\Gallerie;
use AdminBundle\Entity\Rdv;
use AdminBundle\Entity\Modification;
use UserBundle\Form\Type\PatientType;
use UserBundle\Form\Type\PatientEditType;
use AdminBundle\Form\Type\ProImageType; 
use AdminBundle\Form\Type\GallerieType;
use AdminBundle\Entity\Gallery;
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
 * @Route("/pro")
 */
class ProController extends Controller
{
	
	
	 /**
     * @Route("/specialite/{id}/initialise", name="specialite_initialise")
     */
    public function initialiseAction($id , Request $request)
    {
		 $em = $this->getDoctrine()->getManager();
		$docteur = 	$em->getRepository('AdminBundle:Docteur')->find($id);
		
		if($this->getUser()->getProfessionnel()->getId() != $docteur->getProfessionnel()->getId()  ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }
	   $pass = $this->generer_mot_de_passe();
	   $docteur->getCompte()->setPass($pass);
	   $em->flush();
			$request->getSession()->getFlashBag()->add('notice', 'Le compte à bien été initialisé ');
			return $this->redirect($this->generateUrl('docteur_show' , array( "id" => $docteur->getId() ) ));
	   
		
	}
	
    /**
     * @Route("/", name="homepro")
     */
    public function indexAction(Request $request)
    {
        
        		
			$rdvs = array();
			$docteurs = $this->getUser()->getProfessionnel()->getDocteur();
			
			foreach($docteurs as $docteur){
				foreach($docteur->getRdv() as $rdv ){
					array_push($rdvs , $rdv);
				}
			}
        
		if ($request->isMethod('POST')){
			$data = $request->request->get("rdv"); 
			
			if($data){
					$rdv = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Rdv')->find($data);
				if($rdv and $this->getUser()->getProfessionnel()->getId() == $rdv->getDocteur()->getProfessionnel()->getId() ){
					 return $this->redirect($this->generateUrl('pro_rdv_show' , array( "id" => $rdv->getId() ) ));
				}else{
					$request->getSession()->getFlashBag()->add('notice', 'aucun résultat trouvé');
				}
			}else{
				$start = $request->request->get("start"); 
				$end = $request->request->get("end");
					$start = new \DateTime($start);
					$end = new \DateTime($end);
					
				$liste = $this->getDoctrine()->getManager()->getRepository("AdminBundle:Rdv")->findrdv($start , $end , $this->getUser()->getProfessionnel()->getId() );
				
				
				return $this->render('rdv/liste.html.twig', array( "rdvs" => $liste , "start" => $start , "end" => $end
           
				));
			}
			
			
		}
		
		
        return $this->render('rdv/index.html.twig', array( "rdvs" => $rdvs
           
        ));
    }
	
	 /**
     * @Route("/patient", name="pro_patient")
     */
    public function patientHomeAction()
    {
		
		 $em = $this->getDoctrine()->getManager();
		 $result = array();
		 
		 $docteur = $em->getRepository('AdminBundle:Docteur')->findBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));
		 $user = $em->getRepository('AdminBundle:Profil')->findBy(array( 'professionnel' => $this->getUser()->getProfessionnel() ));
			
        
        return $this->render('Pro/patient_index.html.twig', array( "docteur" => $docteur , "user" => $user
           
        ));
    }
	
	
	/**
     * @Route("/mon/profil", name="pro_mon_profil")
     */
    public function profilAction()
    {
		
		 
			
        
        return $this->render('Pro/profil.html.twig', array( 
           
        ));
    }
	
	/**
     * @Route("/liste/rendez-vous", name="pro_rdv_liste")
     */
    public function rdvAction(Request $request)
    {
		
			$rdvs = array();
			$docteurs = $this->getUser()->getProfessionnel()->getDocteur();
			
			foreach($docteurs as $docteur){
				foreach($docteur->getRdv() as $rdv ){
					array_push($rdvs , $rdv);
				}
			}
        
		if ($request->isMethod('POST')){
			$data = $request->request->get("rdv"); 
			
			if($data){
					$rdv = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Rdv')->find($data);
				if($rdv and $this->getUser()->getProfessionnel()->getId() == $rdv->getDocteur()->getProfessionnel()->getId() ){
					 return $this->redirect($this->generateUrl('pro_rdv_show' , array( "id" => $rdv->getId() ) ));
				}else{
					$request->getSession()->getFlashBag()->add('notice', 'aucun résultat trouvé');
				}
			}else{
				$start = $request->request->get("start"); 
				$end = $request->request->get("end");
					$start = new \DateTime($start);
					$end = new \DateTime($end);
					
				$liste = $this->getDoctrine()->getManager()->getRepository("AdminBundle:Rdv")->findrdv($start , $end , $this->getUser()->getProfessionnel()->getId() );
				
				
				return $this->render('rdv/liste.html.twig', array( "rdvs" => $liste , "start" => $start , "end" => $end
           
				));
			}
			
			
		}
		
		
        return $this->render('rdv/index.html.twig', array( "rdvs" => $rdvs
           
        ));
    }
	
	/**
     * @Route("/continuez/rendez-vous/{id}/{name}", name="pro_rdv_continuez")
     */
    public function newAction(Request $request , $id)
    {

		$patient = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Profil')->find($id);
		
		$docteurs = $this->getUser()->getProfessionnel()->getDocteur();
		$specialite = array();
		
		
		foreach($docteurs as $docteur){
			
				foreach($docteur->getListeSpecialite() as $spe ){
					
						if (!in_array($spe->getLibele(), $specialite)){
							
							array_push($specialite , $spe->getLibele());
						}
					
				}
		}
		
		
		
		 return $this->render('rdv/cont.html.twig', array( "patient" => $patient , "specialites" => $specialite
           
        ));
	}	
	
	/**
     * @Route("/ajax/specialite/", name="pro_rdv_specialite")
     */
    public function ajaxSpecialiteAction(Request $request )
    {
		if ($request->isMethod('POST')){
			
			$data = $request->request->get("specialite"); 
			$doc = array();
			
			$docteurs = $this->getUser()->getProfessionnel()->getDocteur();
			
			foreach($docteurs as $docteur){
			
				foreach($docteur->getListeSpecialite() as $spe ){
					
				if($docteur->getRemove() == false){	
					if($spe->getLibele() == $data){
						
						if (!in_array($docteur, $doc)){
							
							array_push($doc , $docteur);
						}
					}
					
				}		
					
				}
			}
			
		
			$docteur = $doc	;
			
			 return $this->render('rdv/listeDocteur.html.twig', array(  "docteurs" => $docteur
           
        ));
			
		}
		
		
		die();
	}
	
	/**
     * @Route("/ajax/agenda/", name="pro_rdv_agenda")
     */
    public function ajaxDocteurAction(Request $request )
    {
		if ($request->isMethod('POST')){
			
			
			
			$data = $request->request->get("docteur"); 
			$ident = $request->request->get("id"); 
			if($ident != 0){
				$edit = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Rdv')->find($ident);
			}else{
				$edit = null;
			}
			
			$semaine = $request->request->get("semaine"); 
			$docteur = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Docteur')->find($data);
			
			$rdvs = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Rdv')->findBy(array('docteur' => $docteur));
			
			
			
			 
			
			
			$time =  array();
			$periode = array();
			$domicile = array();
			$dateRdv = array();
			
			foreach($docteur->getDisponible() as $disponible){
				$debut = new \DateTime($semaine);
				$fin = new \DateTime($semaine);
				
				$debut->modify($disponible->getJour()->getAnglais().' '. $disponible->getHeure()->format('H:i')); 
				$fin->modify($disponible->getJour()->getAnglais().' '. $disponible->getHeureFin()->format('H:i')); 
				
				while($debut <= $fin) {
					
					$tmp = new \DateTime($debut->format('Y-m-d H:i'));
					$now =	new \DateTime();
					
					
				if($tmp > $now ){	
					if($rdvs){
					
						foreach($rdvs as $rdv){
							
							if($rdv->getStatut() == 0){
								array_push($dateRdv , $rdv->getDateRdv()->format('Y-m-d H:i') );
							}
						
						}
						if(!in_array($tmp->format('Y-m-d H:i'), $dateRdv)){
									if (!in_array($tmp, $time)){
										array_push($time , $tmp );
										$periode[$disponible->getJour()->getLibele()][] =  $tmp ;
										$domicile[$disponible->getJour()->getLibele()][] =  $disponible->getDomicile() ;
									}
								
							
						}
						
						
						
					}else{
						
								
								if (!in_array($tmp, $time)){
									
									array_push($time , $tmp ); 
									$periode[$disponible->getJour()->getLibele()][] =  $tmp ;
									$domicile[$disponible->getJour()->getLibele()][] =  $disponible->getDomicile() ;
										
									
								}
						
					}
					
				}
					
					$debut->modify('+'.$disponible->getCreno().' minutes');
					
				
				}
				
			
			}
			
		
			$semaine =	new \DateTime($semaine);
			 return $this->render('rdv/agendaDocteur.html.twig', array( "ident" => $ident , "edit" => $edit , "periodes" => $periode , "times" => $time , "semaine" => $semaine , "domicile" => $domicile
           
        ));
			
		}
		
		
		die();
	}
	
	/**
     * @Route("/annuler/{id}/rendez-vous", name="pro_rdv_annuler")
     */
    public function annulerAction(Rdv $rdv , Request $request)
    {
		if($this->getUser()->getProfessionnel()->getId() != $rdv->getDocteur()->getProfessionnel()->getId() or $rdv->getStatut() != 0  ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }
	   
			$rdv->setStatut(2);
			$this->getDoctrine()->getManager()->flush();
			$request->getSession()->getFlashBag()->add('notice', 'Le rendez-vous a bien été  annulé !');
			return $this->redirect($this->generateUrl('pro_rdv_show' , array( "id" => $rdv->getId() ) ));
		
	}
	
	/**
     * @Route("/new/confirmer/rendez-vous", name="pro_rdv_confirmer")
     */
    public function confirmerAction(Request $request)
    {
		if ($request->isMethod('POST'))
		{
			$patient = $request->request->get("patient"); 
			$specialite = $request->request->get("specialite"); 
			$dispo = $request->request->get("disponible"); 
			$date = $request->request->get("date"); 
			$docteur = $request->request->get("docteur"); 
			$commentaire = $request->request->get("commentaire"); 
			$domicile = $request->request->get("domicile"); 
			$profil = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Profil')->find($patient);
			$spe = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:ListeSpecialite')->findOneBy( array( "libele" => $specialite )  );
			$doc = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Docteur')->find($docteur);
			
			$daterdv =	new \DateTime($date);
			
			
			$rdv = new Rdv(); 
			$rdv->setDocteur($doc);
			$rdv->setSpecialite($spe);
			$rdv->setProfil($profil);
			$rdv->setStatut(0);
			$rdv->setDisponible($dispo);
			$rdv->setCommentaire($commentaire);
			$rdv->setDomicile($domicile);
			$rdv->setDateRdv($daterdv);
			$em = $this->getDoctrine()->getManager();
			$em->persist($rdv);
			$em->flush();
			$em->refresh($rdv);
						
			echo $rdv->getId();
			
			
				
		}
		
		die();
	}
	
	/**
     * @Route("/show/{id}/rendez-vous", name="pro_rdv_show")
     */
    public function afficherRdvAction(Rdv $rdv)
    {
		
		if($this->getUser()->getProfessionnel()->getId() != $rdv->getDocteur()->getProfessionnel()->getId()  ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }
		
		 return $this->render('rdv/show.html.twig', array(  "rdv" => $rdv
           
        ));
	}
	
		
	/**
     * @Route("/editer/{id}/rendez-vous", name="pro_rdv_edit")
     */
    public function editerRdvAction(Rdv $rdv , Request $request)
    {
		
		if($this->getUser()->getProfessionnel()->getId() != $rdv->getDocteur()->getProfessionnel()->getId() or $rdv->getStatut() != 0  ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }
	   
	   
	 
	   $data = $rdv->getSpecialite()->getLibele(); 
			$doc = array(); 
			
			$docteurs = $this->getUser()->getProfessionnel()->getDocteur();
			
			foreach($docteurs as $docteur){
			
				foreach($docteur->getListeSpecialite() as $spe ){
					
				if($docteur->getRemove() == false  ){
					if($docteur->getId() !=  $rdv->getDocteur()->getId() ){			
					if($spe->getLibele() == $data){
						
						if (!in_array($docteur, $doc)){
							
							array_push($doc , $docteur);
						}
					}
					}
				}		
					
				}
			}
		$docteur = $doc	;
		
		if ($request->isMethod('POST'))
		{
			$dispo = $request->request->get("disponible"); 
			$date = $request->request->get("date"); 
			$docteur = $request->request->get("docteur"); 
			$commentaire = $request->request->get("commentaire"); 
			$domicile = $request->request->get("domicile"); 
			$doct = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Docteur')->find($docteur);
			$daterdv =	new \DateTime($date);
			
			$rdv->setDocteur($doct);
			$rdv->setDisponible($dispo);
			$rdv->setCommentaire($commentaire);
			$rdv->setDomicile($domicile);
			$rdv->setDateRdv($daterdv);
			$this->getDoctrine()->getManager()->flush();
			$request->getSession()->getFlashBag()->add('notice', 'operation reussie');
			
						echo 5;
			
			
			
			
			
			die();
		}
		
		
		 return $this->render('rdv/edit.html.twig', array(  "rdv" => $rdv , "docteurs" => $docteur , "id" => $rdv->getDocteur()->getId()
           
        ));
	}
	
	/**
     * @Route("/new/rendez-vous", name="pro_rdv_new")
     */
    public function contAction(Request $request)
    {
		$patient = null;
		
			if ($request->isMethod('POST'))
			{
				
				$data = $request->request->get("data"); 
				
				
				$r = 	$this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findBy( array("username" => $data , "professionnel" => null  )  );
				if(!$r){
					$tel = substr($data, 4);
					
					$r = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Profil')->findBy( array("tel" => $tel )  );
				}
				if(!$r){
					$r = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Profil')->findPatient($data);
				}
				
				
				
				
				$patient = $r;
					
			}
        
        return $this->render('rdv/new.html.twig', array( "patients" => $patient
           
        ));
    }
	
	/**
     * @Route("/ma/galerie", name="pro_mon_galery")
     */
    public function galeryAction(Request $request)
    {
		
		
		$images = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Gallerie')->findOneBy( array("professionnel" => $this->getUser()->getProfessionnel()->getId() ) );
		
	
		
		
		if($images){
			$gallerie = $images;
		}else{
			$gallerie = new Gallerie();
		$gallerie->setProfessionnel($this->getUser()->getProfessionnel());
		}
		
        $form = $this->createForm( GallerieType::class, $gallerie);
		
	
		
		 if($form->handleRequest($request)->isValid()) {
			 
			
			 
            $em = $this->getDoctrine()->getManager();
            $em->persist($gallerie);
            $em->flush();
			$request->getSession()->getFlashBag()->add('notice', 'Opération reussie! ');
            return $this->redirect($this->generateUrl('pro_mon_galery' ));
        }
		
		
        
        return $this->render('Pro/galery.html.twig', array( 
			'form' => $form->createView() , 
			'images' => $images
           
        ));
    }
	
	/**
     * @Route("/password/edit", name="pro_mon_profil_password")
     */
    public function editPasswordAction(Request $request)
    {
		
		 $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.change_password.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
				$request->getSession()->getFlashBag()->add('notice', 'Mot de passe mise à jour! ');
                $url = $this->generateUrl('pro_mon_profil_password');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

       
    
        
        return $this->render('Pro/pro_edit_password.html.twig', array( 
		'form' => $form->createView()
           
        ));
    }
	
	/**
     * @Route("/mon/profil/edit", name="pro_mon_profil_edit")
     */
    public function editAction(Request $request)
    {
		$user = $this->getUser();
		 
		$request->getSession()->set("tel", $user->getProfessionnel()->getTel() );
			
		$liste =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->findAll();
				
			$em = $this->getDoctrine()->getManager();
        $form = $this->createForm( ProfessionelEditType::class, $user);
		
		if ($form->handleRequest($request)->isValid()){
		
			
			
			if($request->getSession()->get("tel") == $user->getProfessionnel()->getTel()){
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($user);
				
				
				$request->getSession()->getFlashBag()->add('notice', 'Mise à jour réussie ');
			}
			else{
			
				$pays =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->find($user->getPays());
				
				$verifNumber = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findNumm($user->getPays() ,$user->getProfessionnel()->getTel() );
				
				
				if($verifNumber){
					
					$request->getSession()->getFlashBag()->add('notice', 'le numéro de  téléphone est déjà utilisé par un autre compte.');
					
				}else{
				$user->addModification($modification);
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($user);
				
				
				$request->getSession()->getFlashBag()->add('notice', 'Mise à jour réussie ');
				
				
				}
			}
															
				
				
				
			}
        
        return $this->render('Pro/pro_edit.html.twig', array(  'form' => $form->createView() , "liste" => $liste
           
        ));
    }
	
	/**
     * @Route("/patient/{id}/show", name="pro_patient_show")
     */
    public function patientShowAction(User $user)
    {
		
		  $etat = false;
		 
		 if($user->getProfil()->getProfessionnel() != null and  $user->getProfil()->getProfessionnel()->getId() == $this->getUser()->getProfessionnel()->getId()){
			 
			 $etat = true;
		 }else{
			 
		 
				foreach( $user->getProfil()->getRdv() as $rdv ){
					
					if($rdv->getDocteur()->getProfessionnel()->getId() == $this->getUser()->getProfessionnel()->getId()   ){
						
						$etat = true;
						break;
					}
				}
		}
		
		if($etat){
			return $this->render('Pro/patient_show.html.twig', array( 'user'   => $user ) );
		}else{
			 return $this->redirect($this->generateUrl('homepro'));
		}
		
			
        
       
    }
	
	/**
     * @Route("/patient/{id}/edit", name="pro_patient_edit")
     */
    public function patientEditAction(User $user, Request $request)
    {
		
		 
		
		
		  $etat = false;
		 
		 if($user->getProfil()->getProfessionnel() != null and  $user->getProfil()->getProfessionnel()->getId() == $this->getUser()->getProfessionnel()->getId()){
			 
			 $etat = true;
		 }else{
			 
		 
				foreach( $user->getProfil()->getRdv() as $rdv ){
					
					if($rdv->getDocteur()->getProfessionnel()->getId() == $this->getUser()->getProfessionnel()->getId()   ){
						
						$etat = true;
						break;
					}
				}
		}
		
		if(!$etat){
			
			return $this->redirect($this->generateUrl('homepro'));
		}
		
			$request->getSession()->set("tel", $user->getProfil()->getTel() );
			
		$liste =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->findAll();
				
			$em = $this->getDoctrine()->getManager();
        $form = $this->createForm( PatientEditType::class, $user);
		
		if ($form->handleRequest($request)->isValid()){
			$commentaire = $request->get("fos_user_registration")["profil"]["commenatire"]; 
		
			$modification = new Modification();
			$modification->setCommentaire($commentaire);
			$modification->setUser($this->getUser());
			$modification->setProfil($user->getProfil());
			$em->persist($modification);
			$em->flush();
			
			if($request->getSession()->get("tel") == $user->getProfil()->getTel()){
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($user);
				
				
				$request->getSession()->getFlashBag()->add('notice', 'Mise à jour réussie ');
			}
			else{
			
				$pays =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->find($user->getPays());
				
				$verifNumber = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findNum($user->getPays() ,$user->getProfil()->getTel() );
				
				
				if($verifNumber){
					
					$request->getSession()->getFlashBag()->add('notice', 'le numéro de  téléphone est déjà utilisé par un autre compte.');
					
				}else{
				$user->addModification($modification);
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($user);
				
				
				$request->getSession()->getFlashBag()->add('notice', 'Mise à jour réussie ');
				
				
				}
			}
															
				
				
				
			}
		
		
		
		
			
        return $this->render('Pro/patient_edit.html.twig', array( 'user'   => $user , 'form' => $form->createView() , "liste" => $liste ) );
       
    }
	
	
	
	
	 /**
     * @Route("/patient/create", name="pro_create")
     */
    public function patientCreateAction(Request $request)
    {
		
		$liste =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->findAll();
			
		$em = $this->getDoctrine()->getManager();
		
		$user = new User();
        $form = $this->createForm( PatientType::class, $user);
		$group = $this->getDoctrine()->getManager()->getRepository('UserBundle:UserGroup')->findOneByName('Profil');
		
		if ($form->handleRequest($request)->isValid()){
			
				$pays =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->find($user->getPays());
				
				$verifNumber = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findNum($user->getPays() ,$user->getProfil()->getTel() );
				
				
				if($verifNumber){
					
					$request->getSession()->getFlashBag()->add('notice', 'le numéro de  téléphone est déjà utilisé par un autre compte.');
					
				}else{
				$pass = $this->generer_mot_de_passe();
				$user->setPlainPassword($pass);
				$user->setUsername($user->getEmail()); 
				$user->setEnabled(true);
				$user->getProfil()->setProfessionnel($this->getUser()->getProfessionnel()); 
				$user->addGroup($group);
				$user->setPays($pays);
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($user);
				
				
				$request->getSession()->getFlashBag()->add('notice', 'le patient à été ajouter avec succès , ses informations de connexion ont été envoyé par mail et sur son mobile ');
				
				$sujet = "Nouvel inscrit patient rdvmedecine";							
				$message = \Swift_Message::newInstance()					
				->setSubject($sujet)						
				->setFrom('infos@rdvmedecine.com')		
				->setTo( array( 'aristide.bationo@rdvmedecine.com', 'didier.assouakon@rdvmedecine.com', 'ghislain.tchimou@rdvmedecine.com' ))		
				->setBody(					
				$this->renderView(			
				'Mail/admin_patient.html.twig', 		
				array('titre' => $sujet , 'user' => $user  )
				),								'text/html' 							) 		
				;								$this->get('mailer')->send($message);


				$sujet = "Confirmation de votre inscription sur rdvmedecine";							
				$message = \Swift_Message::newInstance()					
				->setSubject($sujet)						
				->setFrom('infos@rdvmedecine.com')		
				->setTo( array( $user->getEmail()) )		
				->setBody(					
				$this->renderView(			
				'Mail/patientD.html.twig', 		
				array('titre' => $sujet , 'user' => $user , "pass" => $pass )
				),								'text/html' 							) 		
				;								$this->get('mailer')->send($message);
				
					return $this->redirect($this->generateUrl('pro_patient_show', array('id' => $user->getId())));
				}
				
															
				
				
				
			}
			
			
        
        return $this->render('Pro/patient_create.html.twig', array(  'form' => $form->createView() , "liste" => $liste
           
        ));
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
}
