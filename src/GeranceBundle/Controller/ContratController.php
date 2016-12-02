<?php

namespace GeranceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GeranceBundle\Entity\Contrat;
use UserBundle\Entity\Locataire;
use GeranceBundle\Form\Type\ContratType;

/**
 * Contrat controller.
 *
 * @Route("/contrat")
 */
class ContratController extends Controller
{
    /**
     * Lists all Contrat entities.
     *
     * @Route("/{id}", name="contrat")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Locataire $locataire)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('GeranceBundle:Contrat')->findBy(array('locataire' => $locataire->getId()  ));
        
        return array(
            'entities'  => $entities,
            'locataire'  => $locataire,
        );
    }

    /**
     * Finds and displays a Contrat entity.
     *
     * @Route("/{id}/show", name="contrat_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Contrat $contrat)
    {
        $deleteForm = $this->createDeleteForm($contrat->getId(), 'contrat_delete');

        return array(
            'contrat' => $contrat,
            'delete_form' => $deleteForm->createView(),
        );
    }
	
	 /**
     * Finds and displays a Contrat entity.
     *
     * @Route("/{id}/contrat", name="contrat_word", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function wordAction(Contrat $contrat , Request $request)
    {
		$filename= $request->server->get('DOCUMENT_ROOT')."/zenapi/web/theme/doc/Habitat.rtf";
		
		
		
		if(file_exists($filename)){
			
			if($contrat->getLocataire()->getEntreprise() != null ){
				
				$nomSortie = $contrat->getLocataire()->getEntreprise()->getRaisonSocial();
				
			$fp = fopen ($filename, 'r');
			 $content = fread($fp, filesize($filename)); 
			 fclose ($fp); 
			 $content=str_replace("[nom]",$contrat->getLocataire()->getEntreprise()->getRaisonSocial(),$content); 
			 //On affiche le document word
			header("Content-Type: application/msword" );
			header("Content-Disposition: attachment; filename=contrat-$nomSortie.doc");
			 header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			 
			echo $content;
			
			}else{
				$nomSortie = $contrat->getLocataire()->getParticulier()->getNom();
				
				$fp = fopen ($filename, 'r');
			 $content = fread($fp, filesize($filename)); 
			 fclose ($fp); 
			 $content=str_replace("[nom]",$contrat->getLocataire()->getParticulier()->getNom(),$content); 
			 //On affiche le document word
			header("Content-Type: application/msword" );
			header("Content-Disposition: attachment; filename=contrat-$nomSortie.doc");
			 header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			 
			echo $content;
				
				
			}
		
		
			
			
			
		}
	
        die();
    }

    /**
     * Displays a form to create a new Contrat entity.
     *
     * @Route("/proprietaire/ajax", name="proprietaire_ajax")
     * @Template()
     */
    public function proprietaireAction(Request $request) 
    {
		
		
		if ($request->isMethod('POST')){
		$id = $request->request->get("id"); 
		$em = $this->getDoctrine()->getManager();
        $proprietaire = $em->getRepository('UserBundle:Proprietaire')->find($id);
		$immobilier = $proprietaire->getImmobilier();
		$locative = array();
		$verif = array();
		
		
		foreach($immobilier as $locat){
				foreach($locat->getLocative() as $val){
					$contat = array();
					foreach($val->getContrat() as $cont){
						$contat[] = $cont;
						
					}
					 
					$contratLocative =  end($contat);
					if(!empty($contratLocative)){
						if($contratLocative->getETat() == false ){
							$locative[] = $val;
							if(!in_array($locat->getId(), $verif)){
							array_push($locative , $locat);
							array_push($verif , $locat->getId());
							}
						}
					}else{
							if(!in_array($locat->getId(), $verif)){
							array_push($locative , $locat);
							array_push($verif , $locat->getId());
							}
					}
				}
			
		}

			
		return $this->render('GeranceBundle:contrat:ajax2.html.twig', array( "locative" => $locative
            
        ));
			
		}
		
		

      die();
    }
	
    /**
     * Displays a form to create a new Contrat entity.
     *
     * @Route("/ajax/locative", name="locative_ajax")
     * @Template()
     */
    public function ajaxAction(Request $request) 
    {
		
		
		if ($request->isMethod('POST')){
			
		$id = $request->request->get("id"); 
		$locative = array();
		$em = $this->getDoctrine()->getManager();
        $immobilier = $em->getRepository('GeranceBundle:Immobilier')->find($id);
		
		
			
				foreach($immobilier->getLocative() as $val){
					$contat = array();
					foreach($val->getContrat() as $cont){
						$contat[] = $cont;
					}
					 
					$contratLocative =  end($contat);
					if(!empty($contratLocative)){
						if($contratLocative->getETat() == false ){
							$locative[] = $val;
						}
					}else{
						$locative[] = $val;
					}
				}
			
		return $this->render('GeranceBundle:contrat:ajax.html.twig', array( "locative" => $locative
            
        ));
			
		}
		
		

      die();
    }
	
    /**
     * Displays a form to create a new Contrat entity.
     *
     * @Route("/new/{id}", name="contrat_new")
     * @Template()
     */
    public function newAction(Locataire $locataire) 
    {
		$em = $this->getDoctrine()->getManager();
        $proprietaire = $em->getRepository('UserBundle:Proprietaire')->findAll();
		
        $contrat = new Contrat();
        $form = $this->createForm( ContratType::class, $contrat , array(  )  );
		$locative = array();
		$verif = array();
		
	foreach($proprietaire as $Prop){
		foreach($Prop->getImmobilier() as $locat){
				foreach($locat->getLocative() as $val){
					$contat = array();
					foreach($val->getContrat() as $cont){
						$contat[] = $cont;
						
					}
					 
					$contratLocative =  end($contat);
					if(!empty($contratLocative)){
						if($contratLocative->getETat() == false ){
							$locative[] = $val;
							if(!in_array($Prop->getId(), $verif)){
							array_push($locative , $Prop);
							array_push($verif , $Prop->getId());
							}
						}
					}else{
							if(!in_array($Prop->getId(), $verif)){
							array_push($locative , $Prop);
							array_push($verif , $Prop->getId());
							}
					}
				}
			
		}
	}

        return array(
            'contrat' => $contrat,
			'locative' => $locative,
            'form'   => $form->createView(),
            'locataire'  => $locataire,
        );
    }

    /**
     * Creates a new Contrat entity.
     *
     * @Route("/create/{id}", name="contrat_create")
     * @Method("POST")
     * @Template("GeranceBundle:Contrat:new.html.twig")
     */
    public function createAction(Request $request, Locataire $locataire)
    {
        
			$em = $this->getDoctrine()->getManager();
        $proprietaire = $em->getRepository('UserBundle:Proprietaire')->findAll();
		
        $contrat = new Contrat();
        $form = $this->createForm( ContratType::class, $contrat , array(  )  );
		$locative = array();
		$verif = array();
		
	foreach($proprietaire as $Prop){
		foreach($Prop->getImmobilier() as $locat){
				foreach($locat->getLocative() as $val){
					$contat = array();
					foreach($val->getContrat() as $cont){
						$contat[] = $cont;
						
					}
					 
					$contratLocative =  end($contat);
					if(!empty($contratLocative)){
						if($contratLocative->getETat() == false ){
							$locative[] = $val;
							if(!in_array($Prop->getId(), $verif)){
							array_push($locative , $Prop);
							array_push($verif , $Prop->getId());
							}
						}
					}else{
							if(!in_array($Prop->getId(), $verif)){
							array_push($locative , $Prop);
							array_push($verif , $Prop->getId());
							}
					}
				}
			
		}
	}
		
        if ($form->handleRequest($request)->isValid()) {
			 $em = $this->getDoctrine()->getManager();
			$id = $request->request->get("locative");
			$locative = $em->getRepository('GeranceBundle:Locative')->find($id);
			
           
            $contrat->setLocataire($locataire);
			$contrat->setLocative($locative);
            $em->persist($contrat);
            $em->flush();

            return $this->redirect($this->generateUrl('contrat_show', array('id' => $contrat->getId())));
        }

        return array(
            'contrat' => $contrat,
            'form'   => $form->createView(),
			'locative' => $locative,
            'locataire'  => $locataire,
        );
    }

    /**
     * Displays a form to edit an existing Contrat entity.
     *
     * @Route("/{id}/edit", name="contrat_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Contrat $contrat)
    {
        $editForm = $this->createForm( ContratType::class, $contrat, array(
            'action' => $this->generateUrl('contrat_update', array('id' => $contrat->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($contrat->getId(), 'contrat_delete');

        return array(
            'contrat' => $contrat,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Contrat entity.
     *
     * @Route("/{id}/update", name="contrat_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("GeranceBundle:Contrat:edit.html.twig")
     */
    public function updateAction(Contrat $contrat, Request $request)
    {
        $editForm = $this->createForm( ContratType::class, $contrat, array(
            'action' => $this->generateUrl('contrat_update', array('id' => $contrat->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('contrat_edit', array('id' => $contrat->getId())));
        }
        $deleteForm = $this->createDeleteForm($contrat->getId(), 'contrat_delete');

        return array(
            'contrat' => $contrat,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Contrat entity.
     *
     * @Route("/{id}/delete", name="contrat_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Contrat $contrat, Request $request)
    {
        $form = $this->createDeleteForm($contrat->getId(), 'contrat_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contrat);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contrat'));
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
