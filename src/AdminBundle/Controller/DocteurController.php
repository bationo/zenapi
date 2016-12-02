<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AdminBundle\Entity\Docteur; 
use AdminBundle\Entity\Disponible; 
use AdminBundle\Entity\Compte;
use AdminBundle\Form\Type\DocteurEditType;
use AdminBundle\Form\Type\DocteurType;

/**
 * Docteur controller.
 *
 * @Route("/pro/docteur")
 */
class DocteurController extends Controller
{
    /**
     * Lists all Docteur entities.
     *
     * @Route("/", name="docteur")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Docteur')->findBy( array( "remove" => false ,  "professionnel" => $this->getUser()->getProfessionnel()  ) );
        
      
		return $this->render('docteur/index.html.twig', array(   'entities'   => $entities ));
    }
	
	
	 /**
     * Finds and displays a Docteur entity.
     *
     * @Route("/{id}/disponible/docteur", name="docteur_disponible", requirements={"id"="\d+"})
     * @Template()
     */
    public function disponibiliteAction(Docteur $docteur , Request $request)
    {
        
		if($this->getUser()->getProfessionnel()->getId() != $docteur->getProfessionnel()->getId() or $docteur->getRemove() != false  ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }
	   
        $form = $this->createForm(DocteurEditType::class, $docteur);
       
		 if ($form->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
			$request->getSession()->getFlashBag()->add('notice', 'operation reussie');        
			return $this->redirect($this->generateUrl('docteur_disponible', array('id' => $docteur->getId())));
        }

       
		
		return $this->render('docteur/disponibile.html.twig', array(   'docteur' => $docteur , 'form'   => $form->createView(), ) );
    }
	

    /**
     * Finds and displays a Docteur entity.
     *
     * @Route("/{id}/show", name="docteur_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Docteur $docteur)
    {
        
		if($this->getUser()->getProfessionnel()->getId() != $docteur->getProfessionnel()->getId() or $docteur->getRemove() != false  ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }
		
		$deleteForm = $this->createDeleteForm($docteur->getId(), 'docteur_delete');

       
		
		return $this->render('docteur/show.html.twig', array(   'docteur' => $docteur,
            'delete_form' => $deleteForm->createView(), ));
    }

    /**
     * Displays a form to create a new Docteur entity.
     *
     * @Route("/new", name="docteur_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $docteur = new Docteur();
        $form = $this->createForm(DocteurType::class, $docteur);

       
		
		return $this->render('docteur/new.html.twig', array(   'docteur' => $docteur,
            'form'   => $form->createView(),
			
			));
    }

    /**
     * Creates a new Docteur entity.
     *
     * @Route("/create", name="docteur_create")
     * @Method("POST")
     * @Template("AdminBundle:Docteur:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $docteur = new Docteur();
		 $compte = new Compte();
        $form = $this->createForm(DocteurType::class, $docteur);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
			$compte->setPass($this->pass());
			$docteur->setCompte($compte);
			$docteur->setProfessionnel($this->getUser()->getProfessionnel());
            $em->persist($docteur);
            $em->flush();

            return $this->redirect($this->generateUrl('docteur_show', array('id' => $docteur->getId())));
        }

       
		return $this->render('docteur/new.html.twig', array(   'docteur' => $docteur,
            'form'   => $form->createView(),
			
			));
    }

    /**
     * Displays a form to edit an existing Docteur entity.
     *
     * @Route("/{id}/edit", name="docteur_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Docteur $docteur)
    {
        if($this->getUser()->getProfessionnel()->getId() != $docteur->getProfessionnel()->getId() or $docteur->getRemove() != false ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }
		
		
		$editForm = $this->createForm( DocteurType::class, $docteur, array(
            'action' => $this->generateUrl('docteur_update', array('id' => $docteur->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($docteur->getId(), 'docteur_delete');

       
		
		return $this->render('docteur/edit.html.twig', array(   'docteur' => $docteur,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
			));
    }

    /**
     * Edits an existing Docteur entity.
     *
     * @Route("/{id}/update", name="docteur_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AdminBundle:Docteur:edit.html.twig")
     */
    public function updateAction(Docteur $docteur, Request $request)
    {
       
		if($this->getUser()->getProfessionnel()->getId() != $docteur->getProfessionnel()->getId() or $docteur->getRemove() != false ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }

	   $editForm = $this->createForm(DocteurType::class, $docteur, array(
            'action' => $this->generateUrl('docteur_update', array('id' => $docteur->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
			$request->getSession()->getFlashBag()->add('notice', 'operation reussie');
            return $this->redirect($this->generateUrl('docteur_edit', array('id' => $docteur->getId())));
        }
        $deleteForm = $this->createDeleteForm($docteur->getId(), 'docteur_delete');

        
		
		return $this->render('docteur/edit.html.twig', array(   'docteur' => $docteur,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
			));
    }

    /**
     * Deletes a Docteur entity.
     *
     * @Route("/{id}/delete", name="docteur_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Docteur $docteur, Request $request)
    {
        if($this->getUser()->getProfessionnel()->getId() != $docteur->getProfessionnel()->getId() or $docteur->getRemove() != false ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }
		$array = array();
		foreach($docteur->getRdv() as $rdv){
			if($rdv){
				array_push($array,$rdv);
			}
				
			
		}
		if($array){
			
			$form = $this->createDeleteForm($docteur->getId(), 'docteur_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
			$docteur->setRemove(true);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('docteur'));
			
		}else{
			
			$form = $this->createDeleteForm($docteur->getId(), 'docteur_delete');
			if ($form->handleRequest($request)->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->remove($docteur);
				$em->flush();
			}

			return $this->redirect($this->generateUrl('docteur'));
		
		}
		die();
		
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
	
	protected function pass(){
		$password = "";
		  $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		  
		  for($i = 0; $i < 8; $i++)
		  {
			  $random_int = mt_rand();
			  $password .= $charset[$random_int % strlen($charset)];
		 }
		 
			return $password;
	}

}
