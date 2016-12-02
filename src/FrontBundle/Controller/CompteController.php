<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use AdminBundle\Entity\Contact;
use AdminBundle\Entity\Rdv;
use UserBundle\Entity\User;
use FOS\UserBundle\FOSUserEvents;
use UserBundle\Form\Type\NewType;
use UserBundle\Form\Type\PatientEditType;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Comment controller.
 *
 * @Route("/moncompte")
 */
class CompteController extends Controller
{
	
	
	
	
    /**
     * @Route("/", name="mon_compte")
     */
    public function moncompteAction()
    {
        
		return $this->render('compte/index.html.twig', array( 
            
        ));
    }
	
	 /**
     * @Route("/détail/du/{id}/rendez-vous", name="rdv_detail")
     */
    public function rdvAction(Rdv $rdv)
    {
        
		if($rdv->getProfil()->getUser()->getId() != $this->getUser()->getId()){
			return $this->redirect($this->generateUrl('mon_compte'  ) );
		}
		
		return $this->render('compte/rdvDetail.html.twig', array( "rdv" => $rdv
            
        ));
    }
	
	/**
     * @Route("/fiche/{id}/docteur/", name="rdv_fiche_docteur")
     */
    public function docteurAction(Rdv $rdv)
    {
        
		if($rdv->getProfil()->getUser()->getId() != $this->getUser()->getId()){
			return $this->redirect($this->generateUrl('mon_compte'  ) );
		}
		
		return $this->render('compte/docteur.html.twig', array( "docteur" => $rdv->getDocteur() , "id" => $rdv->getId()
            
        ));
    }
	
     /**
     * @Route("/edit/{id}/rendez-vous", name="rdv_detail_edit")
     */
    public function editAction(Rdv $rdv)
    {
        
		if($rdv->getProfil()->getUser()->getId() != $this->getUser()->getId()){
			return $this->redirect($this->generateUrl('mon_compte'  ) );
		}
		
		return $this->render('compte/editrdv.html.twig', array( "rdv" => $rdv
            
        ));
    }
	
	 /**
     * @Route("/edit/{id}/valide", name="rdv_valide_edit")
     */
    public function valideAction(Rdv $rdv , Request $request)
    {
        
		if($rdv->getProfil()->getUser()->getId() != $this->getUser()->getId()){
			echo 1;
		}
		
		if ($request->isMethod('POST')){
		
			$specialite = $request->request->get("specialite");
			$commentaire = $request->request->get("commentaire");
			$disponible = $request->request->get("disponible");
			$domicile = $request->request->get("domicile");
			$date = $request->request->get("rdv");
			$spe = 	$this->getDoctrine()->getManager()->getRepository('AdminBundle:ListeSpecialite')->findOneBy( array( "libele" => $specialite )  );
			
			
			$daterdv =	new \DateTime($date);
			$rdv->setSpecialite($spe);
			$rdv->setDisponible($disponible);
			$rdv->setCommentaire($commentaire);
			$rdv->setDomicile($domicile);
			$rdv->setDateRdv($daterdv);
			$this->getDoctrine()->getManager()->flush();
						
			echo 5;
		}
		
		die();
    }
	
	/**
     * @Route("/annuler/{id}/rendez-vous", name="front_rdv_annuler")
     */
    public function annulerAction(Rdv $rdv , Request $request)
    {
		
		if($this->getUser()->getId() != $rdv->getProfil()->getUser()->getId() or $rdv->getStatut() != 0  ){
		   return $this->redirect($this->generateUrl('mon_compte'));
	   }
	  
			$rdv->setStatut(2);
			$this->getDoctrine()->getManager()->flush();
			$request->getSession()->getFlashBag()->add('notice', 'Le rendez-vous a bien été  annulé !');
			return $this->redirect($this->generateUrl('rdv_detail' , array( "id" => $rdv->getId() ) ));
		
	}
	
	/**
     * @Route("/profil/show", name="front_rdv_show")
     */
    public function showAction()
    {
		
			
	  
			return $this->render('compte/profil.html.twig', array( 
            
        ));
		
	}
	
	/**
     * @Route("/password/edit", name="front_mon_profil_password")
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

       
    
        
        return $this->render('default/password.html.twig', array( 
		'form' => $form->createView()
           
        ));
    }
	
	
	/**
     * @Route("/profil/edit", name="front_rdv_edit")
     */
    public function edittAction(Request $request)
    {
			
			$pays = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->findAll();
			
			$user = $this->getUser();
			
			$request->getSession()->set("tel", $user->getProfil()->getTel() );
			$form = $this->createForm( PatientEditType::class, $user);
			
			if ($form->handleRequest($request)->isValid()){
				
				
			if($request->getSession()->get("tel") == $user->getProfil()->getTel()){
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($user);
				
				
				$request->getSession()->getFlashBag()->add('notice', 'Mise à jour réussie ');
			}
			else{
			
				$pays =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->find($user->getPays());
				
				$verifNumber = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findNum($user->getPays() ,$user->getProfil()->getTel() );
				
				
				if($verifNumber){
					
					$request->getSession()->getFlashBag()->add('danger', 'le numéro de  téléphone est déjà utilisé par un autre compte.');
					
				}else{
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($user);
				
				
				$request->getSession()->getFlashBag()->add('notice', 'Mise à jour réussie ');
				
				
				}
			}
				
				
			}
	  
			return $this->render('compte/edit.html.twig', array(   "liste" => $pays ,'form' => $form->createView() 
            
        ));
		
	}
	
	
		
	 /**
     * @Route("/agenda/recherche1/ajax", name="agenda_recherche_edit")
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
			
		
		return $this->render('compte/agenda.html.twig', array(  
		"ident" => $ident , "edit" => $edit , "periodes" => $periode , "times" => $time , "semaine" => $semaine , "domicile" => $domicile , "docteur" => $docteur
				));
		}
	}
	
	
	
}
