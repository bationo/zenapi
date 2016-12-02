<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Entity\User; 


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
		$em = $this->getDoctrine()->getManager();
		
  
        return $this->render('default/index.html.twig', array( 
            
        ));
    }
	
	 /**
     * @Route("/recommander/son/medecin", name="recommander_son")
     */
    public function recommanderAction(Request $request)
    {
        
		$em = $this->getDoctrine()->getManager();
		
		$specialite =  $em->getRepository('AdminBundle:ListeSpecialite')->findAll();
		
		
		if ($request->isMethod('POST')){
		
			$nom = $request->request->get("nom");
			$prenom = $request->request->get("prenom");
			$mail = $request->request->get("mail");
			$tel = $request->request->get("tel");
			$nomD = $request->request->get("nomD");
			$specialite = $request->request->get("specialite");
			$telD = $request->request->get("telD");
			$villeD = $request->request->get("villeD");
			$com = $request->request->get("com");
			
			$recom = new Recommandation();
			
			if($this->getUser()){
				if($this->getUser()->getGroups()[0]->getName() == "Profil"){
					 $recom->setProfil($this->getUser()->getProfil());
				}
			}
		
		
			$recom->setNom($nom);
			$recom->setPrenom($prenom);
			$recom->setMail($mail);
			$recom->setTel($tel);
			$recom->setMedecin($nomD);
			$recom->setSpecialite($specialite); 
			$recom->setTelMedecin($telD);
			$recom->setVilleMedecin($villeD);
			$recom->setCommentaire($com);
			$em = $this->getDoctrine()->getManager();
			$em->persist($recom);
			$em->flush();
			$request->getSession()->getFlashBag()->add('notice', 'Nous avons bien reçu votre requete , nous vous recontacterons d\'ici peu !');
			
		}
  
        return $this->render('default/recommander.html.twig', array( "specialites" => $specialite
            
        ));
    }
	
	
	
	
	/**
     * @Route("/verif/tel/ajax", name="verif_tel_ajax")
     */
    public function verifAction(Request $request)
    {
		if ($request->isMethod('POST')){
		
			$tel = $request->request->get("tel");
			
			 $code = new Code();
			
			 $code->setTel($tel);
			 $code->setEtat(false);
			 $code->setUser($this->getUser());
			 
			  $em = $this->getDoctrine()->getManager();
			  $em->persist($code);
			  $em->flush();
			  $em->refresh($code);
			
				echo 1;
		}
		
		
		
		die();
	}
	
	
	/**
     * @Route("/inscription/patient/ajax", name="inscription_patient_ajax")
     */
    public function inscriptionAction(Request $request)
    {
		
		if ($request->isMethod('POST')){
		
			$mail = $request->request->get("mail"); 
			$pass = $request->request->get("pass"); 
			$pass2 = $request->request->get("pass2"); 
			$nom = $request->request->get("nom"); 
			$prenom = $request->request->get("prenom"); 
			$lieu = $request->request->get("lieu"); 
			$ville = $request->request->get("ville"); 
			$Idpays = $request->request->get("pays"); 
			$tel = $request->request->get("tel"); 
			$jour = $request->request->get("jour"); 
			$mois = $request->request->get("mois"); 
			$genre = $request->request->get("genre"); 
			$anne = $request->request->get("anne");
			$date = $anne.'-'.$mois.'-'.$jour;
			$date = new \DateTime($date);
			
			$verifMail = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findOneByEmail($mail);
			$pays =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->find($Idpays);
			
			if($verifMail){
				echo 1;
			}else{
				$verifNumber = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findNum($Idpays , $tel );
				if($verifNumber){
					echo 2;
				}else{
					$group = $this->getDoctrine()->getManager()->getRepository('UserBundle:UserGroup')->findOneByName('Profil');
					
					$user = new User();
					$profil = new Profil();
					$profil->setNom($nom);
					$profil->setGenre($genre);
					$profil->setPrenom($prenom);
					$profil->setLieuNaissance($lieu);
					$profil->setVille($ville);
					$profil->setTel($tel);
					$profil->setDateNaissance($date);
					$user->setProfil($profil);
					$user->setPlainPassword($pass);
					$user->setUsername($mail);
					$user->setEmail($mail);					
					$user->setEnabled(true);
					$user->addGroup($group);
					$user->setPays($pays);
					$userManager = $this->get('fos_user.user_manager');
					$userManager->updateUser($user);
					
				$firewallName = $this->container->getParameter('fos_user.firewall_name');
				$token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, $user->getRoles());
				$this->get('security.token_storage')->setToken($token);
				$request->getSession()->set('_security_main', serialize($token));
					echo 3;
				}
			}
			
			
			
		
		}
		die();
	}
	
	/**
     * @Route("/votre-rdv/{id}/confirmer", name="rdv_confirmer")
     */
    public function confirmerAction(Rdv $rdv)
    {
		if($this->getUser()->getProfil()->getId() != $rdv->getProfil()->getId() or $rdv->getStatut() != 0  ){
		   return $this->redirect($this->generateUrl('homepage'));
	   }
		
		
		return $this->render('default/confirmer.html.twig', array( "rdv" => $rdv
            
        ));
	}
	
	/**
     * @Route("/les-professionels/{id}/{{name}}", name="professionel_name")
     */
    public function pageAction(Professionnel $prof)
    {
		
		$images = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Gallerie')->findOneBy( array("professionnel" => $prof->getId() ) );

		$docteurs = $prof->getDocteur();
		$specialite = array();
		
		
		foreach($docteurs as $docteur){
			
				foreach($docteur->getListeSpecialite() as $spe ){
					
						if (!in_array($spe->getLibele(), $specialite)){
							
							array_push($specialite , $spe->getLibele());
						}
					
				}
		}
		
		
		
		return $this->render('default/prof.html.twig', array( "prof" => $prof , "specialites" => $specialite , "images" => $images
            
        ));
	}
	
	/**
     * @Route("/front/ajax/specialite/", name="front_rdv_specialite")
     */
    public function ajaxSpecialiteAction(Request $request )
    {
		if ($request->isMethod('POST')){
			
			$data = $request->request->get("specialite"); 
			$prof = $request->request->get("prof");
			$professionel = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Professionnel')->find($prof);
			$doc = array();
			
			$docteurs = $professionel->getDocteur();
			
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
			
			 return $this->render('default/listeDocteur.html.twig', array(  "docteurs" => $docteur
           
        ));
			
		}
		
		
		die();
	}
	
	
	/**
     * @Route("/verif/code/ajax", name="verif_code_ajax")
     */
    public function codeAction(Request $request)
    {
		
		
		
		
		if ($request->isMethod('POST')){
			$code = $request->request->get("code"); 
			$tel = $request->request->get("tel"); 
			
			
		$verifCode = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Code')->findOneBy(array('id' => $code,'tel' => $tel , 'etat' => '0' ));
		if($verifCode){
			
			$specialite = $request->request->get("specialite"); 
			$dispo = $request->request->get("disponible"); 
			$date = $request->request->get("rdv"); 
			$docteur = $request->request->get("docteur"); 
			$commentaire = $request->request->get("commentaire"); 
			$domicile = $request->request->get("domicile"); 
			$spe = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:ListeSpecialite')->findOneBy( array( "libele" => $specialite )  );
			$doc = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:Docteur')->find($docteur);
			$telv = $request->request->get("telv");  
			$commune = $request->request->get("commune");
			$daterdv =	new \DateTime($date);
			
			
			$em = $this->getDoctrine()->getManager();
			$user = $this->getUser();
			
			$user->getProfil()->setVille($commune);
			$user->getProfil()->setTel($telv);
			$rdv = new Rdv(); 
			$rdv->setDocteur($doc);
			$rdv->setSpecialite($spe);
			$rdv->setProfil($this->getUser()->getProfil()); 
			$rdv->setStatut(0);
			$rdv->setDisponible($dispo);
			$rdv->setCommentaire($commentaire);
			$rdv->setDomicile($domicile);
			$rdv->setDateRdv($daterdv);
			$verifCode->setEtat(1);
			
			$em->persist($rdv);
			$em->flush();
			$em->refresh($rdv);
						
			echo $rdv->getId();
			
		}else{
			echo 1;
		}	
			
			
			
			
		}
		
		die();
	}
	
	
	/**
     * @Route("/prendre/rendez-vous", name="prendre_rendez")
     */
    public function prendreAction(Request $request)
    {
		
		if ($request->isMethod('POST')){
			
			
			
			$doc = $request->request->get("docteur"); 
			$domicile = $request->request->get("domicile"); 
			$date = $request->request->get("date"); 
			$date = new \DateTime($date);
			$docteur = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Docteur')->find($doc);
			$pays = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->findAll();
			
			$user = new User();
			$form = $this->createForm( NewType::class, $user);
		
			
			return $this->render('default/confirme.html.twig', array(  
		"date" => $date , "docteur" => $docteur , "domicile" => $domicile , "liste" => $pays ,'form' => $form->createView() 
				));
		}else{
			 return $this->redirect($this->generateUrl('homepage'));
		}
	}
	
	public function rechercheFormAction(Request $request)
    {
		$specialites =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:ListeSpecialite')->findAll();
		
		return $this->render('default/search_form.html.twig', array(  
		"specialites" => $specialites
				));
	}
	
	/**
     * @Route("/agenda/recherche/ajax", name="agenda_recherche_ajax")
     */
    public function rechercheAjaxAction(Request $request)
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
										$periode[$disponible->getJour()->getAbreger()][] =  $tmp ;
										$domicile[$disponible->getJour()->getAbreger()][] =  $disponible->getDomicile() ;
									}
								
							
						}
						
						
						
					}else{
						
								
								if (!in_array($tmp, $time)){
									
									array_push($time , $tmp ); 
									$periode[$disponible->getJour()->getAbreger()][] =  $tmp ;
									$domicile[$disponible->getJour()->getAbreger()][] =  $disponible->getDomicile() ;
										
									
								}
						
					}
					
				}
					
					$debut->modify('+'.$disponible->getCreno().' minutes');
					
				
				}
				
			
			}
			
		
		return $this->render('default/agenda.html.twig', array(  
		"ident" => $ident , "edit" => $edit , "periodes" => $periode , "times" => $time , "semaine" => $semaine , "domicile" => $domicile , "docteur" => $docteur
				));
		}
	}
	
	
	
	
	 /**
     * @Route("/connexion/user/ajax", name="connexion_user_ajax")
     */
    public function userAjax1Action(Request $request)
    {
		if ($request->isMethod('POST')){
		$user = $request->request->get("user"); 
		$pass = $request->request->get("pass");
		
				$etat = $this->login($user , $pass);
				if ($etat == "false"){
					echo 2;
				}else{
					
			   $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findOneByUsername($user);
					
				$firewallName = $this->container->getParameter('fos_user.firewall_name');
				$token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, $user->getRoles());
				$this->get('security.token_storage')->setToken($token);
				$request->getSession()->set('_security_main', serialize($token));	
				
				echo 1;
				}
				


		}
		
		die();
	}
	
     /**
     * @Route("/user/information/ajax", name="information_user")
     */
    public function userAjaxAction(Request $request)
    {
		
		
			return $this->render('default/user_info.html.twig');
	
	}
	
	
	
	 /**
     * @Route("/agenda/recherche1/ajax", name="agenda_recherche1_ajax")
     */
    public function rechercheAjax1Action(Request $request)
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
										$periode[$disponible->getJour()->getAbreger()][] =  $tmp ;
										$domicile[$disponible->getJour()->getAbreger()][] =  $disponible->getDomicile() ;
									}
								
							
						}
						
						
						
					}else{
						
								
								if (!in_array($tmp, $time)){
									
									array_push($time , $tmp ); 
									$periode[$disponible->getJour()->getAbreger()][] =  $tmp ;
									$domicile[$disponible->getJour()->getAbreger()][] =  $disponible->getDomicile() ;
										
									
								}
						
					}
					
				}
					
					$debut->modify('+'.$disponible->getCreno().' minutes');
					
				
				}
				
			
			}
			
		
		return $this->render('default/agenda1.html.twig', array(  
		"ident" => $ident , "edit" => $edit , "periodes" => $periode , "times" => $time , "semaine" => $semaine , "domicile" => $domicile , "docteur" => $docteur
				));
		}
	}
	
	/**
     * @Route("/recherche/{type}", name="recherche")
     */
    public function rechercheAction(Request $request , $type)
    {
        $em = $this->getDoctrine()->getManager();
		
		$specialites =  $em->getRepository('AdminBundle:ListeSpecialite')->findAll();
		
		if($request->isMethod('post') ){
			
			$semaine = new \DateTime();
			
			if($type == "specialite"){
				
				$specialite = $request->get("searchCategory");
				
				$location = $request->get("location");
			$liste = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Docteur')->findDocteurSpecialite($specialite ,$location );
			
			
				
				 return $this->render('default/result.html.twig', array( "semaine" => $semaine, "liste" => $liste , "specialites" => $specialites , "specialite" => $specialite
            
				));
				
			}
			
			if($type == "praticien"){
				
				$praticien = $request->get("query");
				$location = $request->get("location");
			$liste = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Docteur')->findDocteurDocteur($praticien ,$location);
				
				return $this->render('default/result.html.twig', array( "semaine" => $semaine , "liste" => $liste , "specialites" => $specialites
            
				));
				
			}
			
		}else{
			 return $this->redirect($this->generateUrl('homepage'));
		}
		
		
		die();
  
       
    }
	
	
	
	 /**
     * @Route("/ajax/specialite", name="ajax_specialite")
     */
    public function ajaxAction(Request $request)
    {
        
			$em = $this->getDoctrine()->getManager();
			
			$specialite =  $em->getRepository('AdminBundle:ListeSpecialite')->findAll();
			
			$element = array();
			foreach($specialite as $elem){
				$element[] = $elem->getLibele();
			}
			echo json_encode($element); 
		
	   die();
    }
	
	
	 /**
     * @Route("patient/register", name="patient_register")
     */
    public function registerPatientAction(Request $request)
    {
        if($this->getUser()){
			if($this->getUser()->getGroups()[0]->getName() == "Profil"){
				return $this->redirect($this->generateUrl('front_rdv_show'));
			}
		}
		
		
		
		$em = $this->getDoctrine()->getManager();
		
        $user = new User();
		$form = $this->createForm( NewType::class, $user);
		$pays = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->findAll();	
		$group = $this->getDoctrine()->getManager()->getRepository('UserBundle:UserGroup')->findOneByName('Profil');
		
		if ($form->handleRequest($request)->isValid()){
			
				$pays =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->find($user->getPays()->getNom()->getId());
				
				$verifNumber = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findNum($user->getPays()->getNom()->getId() ,$user->getProfil()->getTel() );
				
				
				if($verifNumber){
					
					$request->getSession()->getFlashBag()->add('notice', 'le numéro de  téléphone est déjà utilisé par un autre compte.');
					
				}else{
					$user->setUsername($user->getEmail()); 
				$user->setEnabled(true);
				$user->addGroup($group);
				$user->setPays($pays);
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($user);
				
				
				$firewallName = $this->container->getParameter('fos_user.firewall_name');
				 $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, $user->getRoles());
				$this->get('security.token_storage')->setToken($token);
				$request->getSession()->set('_security_main', serialize($token));
				
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
				'Mail/patient.html.twig', 		
				array('titre' => $sujet , 'user' => $user  )
				),								'text/html' 							) 		
				;								$this->get('mailer')->send($message);
				}
				
															
				
				
				
			}
		
  
        return $this->render('default/patientRegister.html.twig', array( 'form'   => $form->createView() , "liste" => $pays
            
        ));
    }
	
	/**
     * @Route("professionel/de/sante", name="professionel")
     */
    public function ProfessionnelAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$specialite =  $em->getRepository('AdminBundle:ListeSpecialite')->findAll();
		$pays =  $em->getRepository('AdminBundle:Pays')->findAll();
		
		if ($request->isMethod('POST')){
			
			$nom = $request->request->get("nom"); 
			$prenom = $request->request->get("prenom"); 
			$tel = $request->request->get("tel"); 
			$specialite = $request->request->get("specialite"); 
			$commentaire = $request->request->get("commentaire"); 
			$pays = $request->request->get("pays"); 
			$ville = $request->request->get("ville"); 
			
			$prospect = new Prospect();
			$prospect->setNom($nom);
			$prospect->setPrenom($prenom);
			$prospect->setTel($tel);
			$prospect->setSpecialite($specialite);
			$prospect->setCommentaire($commentaire);
			$prospect->setPays($pays);
			$prospect->setVille($ville);
			$em = $this->getDoctrine()->getManager();
            $em->persist($prospect);
            $em->flush();
			
			echo 1;
			die();
		}
		
		
		
		return $this->render('default/professionel.html.twig', array( "specialites" => $specialite , "pays" => $pays
            
        ));
	}
	
	
	
	
	
	/**
     * @Route("professionel/register", name="professionel_register")
     */
    public function registerProfessionnelAction(Request $request)
    {
        
		$em = $this->getDoctrine()->getManager();
		
		$user = new User();
        $form = $this->createForm( ProfessionelType::class, $user);
		$group = $this->getDoctrine()->getManager()->getRepository('UserBundle:UserGroup')->findOneByName('Pro');
		
		if ($form->handleRequest($request)->isValid()){
			
				$pays =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->find($user->getPays()->getNom()->getId());
				
				$verifNumber = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findNumm($user->getPays()->getNom()->getId() ,$user->getProfessionnel()->getTel() );
				
				
				if($verifNumber){
					
					$request->getSession()->getFlashBag()->add('notice', 'le numéro de  téléphone est déjà utilisé par un autre compte.');
					
				}else{
					$user->setUsername($user->getEmail()); 
				$user->setEnabled(false);
				$user->addGroup($group);
				$user->setPays($pays);
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($user);
				
				
				
				
				$sujet = "Nouvel inscrit professionel rdvmedecine";							
				$message = \Swift_Message::newInstance()					
				->setSubject($sujet)						
				->setFrom('infos@rdvmedecine.com')		
				->setTo( array( 'aristide.bationo@rdvmedecine.com', 'didier.assouakon@rdvmedecine.com', 'ghislain.tchimou@rdvmedecine.com' ))		
				->setBody(					
				$this->renderView(			
				'Mail/admin_pro.html.twig', 		
				array('titre' => $sujet , 'user' => $user  )
				),								'text/html' 							) 		
				;								$this->get('mailer')->send($message);


				$sujet = "Nous avons bien reçu votre demande sur  rdvmedecine";							
				$message = \Swift_Message::newInstance()					
				->setSubject($sujet)						
				->setFrom('infos@rdvmedecine.com')		
				->setTo( array( $user->getEmail()) )		
				->setBody(					
				$this->renderView(			
				'Mail/pro.html.twig', 		
				array('titre' => $sujet , 'user' => $user  )
				),								'text/html' 							) 		
				;								$this->get('mailer')->send($message);
				}
				
															
				return $this->render('default/valid.html.twig');
				
				
			}
		
  
        return $this->render('default/proRegister.html.twig', array( 'form'   => $form->createView()
            
        ));
    }
	
	public function blocAction()
    {
		
   
	  $em = $this->getDoctrine()->getManager();
		
		$specialite =  $em->getRepository('AdminBundle:ListeSpecialite')->findAll();


      return $this->render('default/bloc.html.twig', array( "specialites" => $specialite ));
    }

    /**
     * Contact page
     *
     * @Route("/contact", name="contact")
     * @Method({"GET","POST"})
     */
    public function contactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AdminBundle:Setting')->findOneById(1);

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        if ($form->handleRequest($request)->isValid()) {
            $em->persist($message);
            $em->flush();

            $message = 'Votre message a été envoyé avec succes.';

            $request->getSession()->getFlashBag()->add('notice', $message);

            return $this->redirect($this->generateUrl('contact'));
        }

        return $this->render('default/contact.html.twig', array(
            'setting' => $setting,
            'message' => $message,
            'form'   => $form->createView(),
        ));
    }

    /**
     * About page
     *
     * @Route("/synopsis", name="synopsis")
     * @Method("GET")
     */
    public function synopsisAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AdminBundle:Setting')->findOneById(1);

        return $this->render('default/synopsis.html.twig', array(
            'synopsis' => $setting->getAbout(),
        ));
    }

    /***
     * Get ticket form
     *
     * @return layout
     */
    public function ticketFormAction($route, $parameters)
    {
        $ticket = new Ticket();
        $ticket_form = $this->createForm(TicketType::class, $ticket);

        return $this->render('default/ticket_form.html.twig', array(
            'ticket_form' => $ticket_form->createView(),
            'route'       => $route,
            'parameters'  => $parameters,
        ));
    }

    /**
     * Recherche
     *
     * @Route("/ticket", name="ticket")
     * @Method("POST")
     */
    public function ticketAction(Request $request)
    {
        $ticket = new Ticket();
        $ticket_form = $this->createForm(TicketType::class, $ticket);

        if ($ticket_form->handleRequest($request)->isValid()) {
            $route = $ticket_form->get('route')->getData();
            $params = $ticket_form->get('parameters')->getData();
            if ($params !== "" and $params !== null) {
                $params = explode(';', $params);
                foreach($params as $value) {
                    if ($value !== '') {
                        $tmp = explode(':', $value);
                        $parameters[$tmp[0]] = $tmp[1];
                    }
                }
                //dump($parameters);die();
            } else {
                $parameters = array();
            }

            $em = $this->getDoctrine()->getManager();

            $booked_status = $em->getRepository('AdminBundle:Status')->findOneBySlug('reserve');
            $ticket->setStatus($booked_status);

            $em->persist($ticket);
            $em->flush();

            $this->get('session')->getFlashBag()->add('ticket', 'Votre commande a bien été enregistré. Merci pour votre confiance.');

            return $this->redirect($this->generateUrl($route, $parameters));
        }

        return $this->redirect($this->generateUrl('homepage'));
    }

    /***
     * Get header form
     *
     * @return layout
     */
    public function searchFormAction()
    {
        $search_form = $this->createForm(AppSearchType::class);

        return $this->render('default/search_form.html.twig', array(
            'search_form' => $search_form->createView()
        ));
    }

    /**
     * Recherche
     *
     * @Route("/recherche", name="search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $search = $this->createForm(AppSearchType::class);

        $session = $request->getSession();

        if ($search->handleRequest($request)->isValid()) {
            $session->set('word', $search->get('search')->getData());
        }

        $word = $session->get('word');

        $posts = $this->get('knp_paginator')->paginate(
            $this->getDoctrine()->getRepository("AdminBundle:Post")->findBySearch($word),
            $request->query->getInt('page', 1),
            8
        );

        $categories = $this->getDoctrine()->getRepository("AdminBundle:SubCategory")->findByCategorySlugWithPosts("affairage");

        return $this->render('default/search.html.twig', array(
            'posts'      => $posts,
            'word'       => $word,
            'categories' => $categories
        ));
    }

    /***
     * Get footer newsletter form
     *
     * @return layout
     */
    public function newsletterFormAction($route, $parameters)
    {
        $newsletter_form = $this->createForm(NewsletterType::class);

        return $this->render('default/newsletter_form.html.twig', array(
            'newsletter_form' => $newsletter_form->createView(),
            'route' => $route,
            'parameters' => $parameters,
        ));
    }

    /**
     * Newsletter
     *
     * @Route("/newsletter", name="newsletter")
     * @Method("POST")
     */
    public function newsletterAction(Request $request)
    {
        $form = $this->createForm(NewsletterType::class);

        if ($form->handleRequest($request)->isValid()) {
            $route = $form->get('route')->getData();
            $params = $form->get('parameters')->getData();
            if ($params !== "" and $params !== null) {
                $params = explode(';', $params);
                foreach($params as $value) {
                    if ($value !== '') {
                        $tmp = explode(':', $value);
                        $parameters[$tmp[0]] = $tmp[1];
                    }
                }
                //dump($parameters);die();
            } else {
                $parameters = array();
            }

            $em = $this->getDoctrine()->getManager();

            $email = $form->get('email')->getData();
            $newsletter = $em->getRepository("AdminBundle:Newsletter")->findOneByEmail($email);

            if (!$newsletter) {
                $newsletter = new Newsletter($email);
                $em->persist($newsletter);
                $em->flush();

                $this->get('session')->getFlashBag()->add('newsletter', 'Votre email a bien été enregistré. Merci de votre confiance.');
            } else {
                $this->get('session')->getFlashBag()->add('newsletter', 'Votre email est déjà existant. Merci de votre confiance.');
            }

            return $this->redirect($this->generateUrl($route, $parameters));
        }

        return $this->redirect($this->generateUrl('homepage'));
    }
	
	
	protected function DocteurAction($IDdocteur , $semaine)
    {
			
			
			
			
			
			$docteur = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Docteur')->find($IDdocteur);
			
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
			$result = array();
			$result[] = $periode;
			$result[] = $semaine;
			$result[] = $domicile;
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
