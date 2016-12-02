<?php

namespace GeranceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GeranceBundle\Entity\Immobilier;
use UserBundle\Entity\Proprietaire;
use AdminBundle\Entity\Docs;
use AdminBundle\Entity\Document;
use GeranceBundle\Form\Type\ImmobilierType;
use GeranceBundle\Form\Type\DocType;
use GeranceBundle\Form\Type\JustiType;

/**
 * Immobilier controller.
 *
 * @Route("/immobilier")
 */ 
class ImmobilierController extends Controller
{
    /**
     * Lists all Immobilier entities.
     *
     * @Route("/{id}", name="immobilier")
     * @Template()
     */
    public function indexAction(Proprietaire $proprietaire )
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('GeranceBundle:Immobilier')->findBy( array( "proprietaire" => $proprietaire->getId() ) );
        
        return array(
            'entities'  => $entities,
			'proprietaire'  => $proprietaire,
        );
    }

	
     /**
     * Finds and displays a Contrat entity.
     *
     * @Route("/{id}/mandat/immobilier", name="mandat_word" )
     * @Method("GET")
     * @Template()
     */
    public function wordAction(Immobilier $immobilier , Request $request)
    {
		$filename= $request->server->get('DOCUMENT_ROOT')."/zenapi/web/theme/doc/Habitat.rtf";
		
		
		
		if(file_exists($filename)){
			
			if($immobilier->getProprietaire()->getEntreprise() != null ){
				
				$nomSortie = $immobilier->getProprietaire()->getEntreprise()->getRaisonSocial();
				
			$fp = fopen ($filename, 'r');
			 $content = fread($fp, filesize($filename)); 
			 fclose ($fp); 
			 $content=str_replace("[nom]",$immobilier->getProprietaire()->getEntreprise()->getRaisonSocial(),$content); 
			 //On affiche le document word
			header("Content-Type: application/msword" );
			header("Content-Disposition: attachment; filename=mandat-$nomSortie.doc");
			 header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			 
			echo $content;
			
			}else{
				$nomSortie = $immobilier->getProprietaire()->getParticulier()->getNom();
				
				$fp = fopen ($filename, 'r');
			 $content = fread($fp, filesize($filename)); 
			 fclose ($fp); 
			 $content=str_replace("[nom]",$immobilier->getProprietaire()->getParticulier()->getNom(),$content); 
			 //On affiche le document word
			header("Content-Type: application/msword" );
			header("Content-Disposition: attachment; filename=mandat-$nomSortie.doc");
			 header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			 
			echo $content;
				
				
			}
		
		
			
			
			
		}
	
        die();
    }
	
    /**
     * Finds and displays a Immobilier entity.
     *
     * @Route("/{id}/show", name="immobilier_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Immobilier $immobilier)
    {
        $deleteForm = $this->createDeleteForm($immobilier->getId(), 'immobilier_delete');

        return array(
            'immobilier' => $immobilier,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Immobilier entity.
     *
     * @Route("/new/{id}", name="immobilier_new")
     * @Template()
     */
    public function newAction(Proprietaire $proprietaire)
    {
        $immobilier = new Immobilier();
        $form = $this->createForm( ImmobilierType::class , $immobilier);

        return array(
            'immobilier' => $immobilier,
			'proprietaire' => $proprietaire,
            'form'   => $form->createView(),
        );
    }

	
	 /**
     * Creates a new Immobilier entity.
     *
     * @Route("/document/{id}", name="document_create")
     * @Template("GeranceBundle:Immobilier:document.html.twig")
     */
    public function docAction(Request $request , Immobilier $immobilier)
    {
        $form = $this->createForm(DocType::class, $immobilier);
		
		$imo = $request->request;
		dump($imo);
		die();
		
		
		if ($form->handleRequest($request)->isValid()){
			$immobilier->setMandat(true);
            $this->getDoctrine()->getManager()->flush();

            echo 3;
            die();
        }
		
		
       

        return array(
            'immobilier' => $immobilier,
            'form'   => $form->createView(),
        );
    }
	
	
	/**
     * Creates a new Immobilier entity.
     *
     * @Route("/justificatif/{id}", name="document_justificatif" , defaults={"id" = null })
     * @Template("GeranceBundle:Immobilier:justificatif.html.twig")
     */
    public function justAction(Request $request ,  $id = null)
    {
		        $em = $this->getDoctrine()->getManager();
        
		if($id == null){
					$immobilier = new Immobilier();
				 $form = $this->createForm(JustiType::class, $immobilier);
			
		}else{
			$immobilier = $em->getRepository('GeranceBundle:Immobilier')->find($id);
			 $form = $this->createForm(JustiType::class, $immobilier);
			
		}
       
		
		if ($form->handleRequest($request)->isValid()){
			$immobilier->setMandat(true);
            $this->getDoctrine()->getManager()->flush();

            echo 3;
            die();
        }
		
		
       

        return array(
			'id' => $id,
            'immobilier' => $immobilier,
            'form'   => $form->createView(),
        );
    }
	
	
	 /**
     * Creates a new Immobilier entity.
     *
     * @Route("/resilier/{id}", name="document_resilier")
     */
    public function resilierAction(Request $request , Immobilier $immobilier)
    {
		
			$immobilier->setMandat(false);
            $this->getDoctrine()->getManager()->flush();

            echo 3;
            die();
		
    }	
	
	
	
    /**
     * Creates a new Immobilier entity.
     *
     * @Route("/create/{id}", name="immobilier_create")
     * @Template("GeranceBundle:Immobilier:new.html.twig")
     */
    public function createAction(Request $request , Proprietaire $proprietaire)
    {
        $immobilier = new Immobilier();
		
        $form = $this->createForm(ImmobilierType::class, $immobilier);
		
		if ($request->isMethod('POST')){
			
		
			$immobilier->setVente($request->request->get("immobilier")['vente']);
			$immobilier->setType($request->request->get("immobilier")['type']);
			$immobilier->setNom($request->request->get("immobilier")['nom']);
			$immobilier->setCommune($request->request->get("immobilier")['commune']);
			$immobilier->setCommission($request->request->get("immobilier")['commission']);
			$immobilier->setGeographique($request->request->get("immobilier")['geographique']);
			$immobilier->setSuperficie($request->request->get("immobilier")['superficie']);
			$immobilier->setIlot($request->request->get("immobilier")['ilot']);
			$immobilier->setTitreFoncier($request->request->get("immobilier")['titreFoncier']);
			$immobilier->setLot($request->request->get("immobilier")['lot']);
			$immobilier->setMontant($request->request->get("immobilier")['montant']);
			$immobilier->setQuartier($request->request->get("immobilier")['quartier']);
			$immobilier->setDescription($request->request->get("immobilier")['description']);
			$etat = true; 
			$extensions_valides = array( "image/jpeg", "image/gif", "image/png" , "image/jpg", "application/pdf" , "application/x-pdf" );
			$maxsize = 5242880;
			
			
			  
				if(isset($request->request->get("immobilier")['justificatif'])){
							foreach($request->request->get("immobilier")['justificatif'] as $key => $justificatif){
								
								if($_FILES['immobilier']['error']['justificatif'][$key]["document"]["tempFile"] == 0 and  $_FILES['immobilier']['size']['justificatif'][$key]["document"]["tempFile"] <= $maxsize and in_array($_FILES['immobilier']['type']['justificatif'][$key]["document"]["tempFile"],$extensions_valides) ){
									
									$etat = true;
								}else{
									$etat = false;
									$request->getSession()->getFlashBag()->add('notice', 'Une erreure est survenue pendant l\'envoie !');
									echo "Une erreure est survenue pendant l\'envoie !";
									break;
								}
								
							
							}
					
					
				}
				if($etat){
					$em = $this->getDoctrine()->getManager();
					$immobilier->setProprietaire($proprietaire);
					$immobilier->setEtat(false);
					$em->persist($immobilier);
					$em->flush();
					$em->refresh($immobilier);
					
					if(isset($request->request->get("immobilier")['justificatif'])){
							foreach($request->request->get("immobilier")['justificatif'] as $key => $justificatif){
								
								$filename = $_FILES['immobilier']['name']['justificatif'][$key]["document"]["tempFile"];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);
								
					
								$Document = new Docs();
								$file = new Document();
								$file->setTempFile($request->files->get("immobilier")['justificatif'][$key]['document']);
								$file->setAlt($filename);
								$file->setUrl($ext);
								$Document->setTitle($justificatif['title']);
								$Document->setDocument($file);
								$Document->setImmobilier($immobilier);
								$em->persist($Document);
								$em->flush();
								$em->refresh($Document);
								
								$photoDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/documents/' . basename($Document->getDocument()->getId() . '.' . $ext );
								move_uploaded_file($_FILES['immobilier']['tmp_name']['justificatif'][$key]["document"]["tempFile"],$photoDir);
								
								
							}
					}
					echo 3;
					
				}
		die();
		}
		
        
        return array(
			'proprietaire' => $proprietaire,
            'immobilier' => $immobilier,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Immobilier entity.
     *
     * @Route("/{id}/edit", name="immobilier_edit")
     * @Template()
     */
    public function editAction(Immobilier $immobilier)
    {
        $editForm = $this->createForm(ImmobilierType::class, $immobilier, array(
            'action' => $this->generateUrl('immobilier_update', array('id' => $immobilier->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($immobilier->getId(), 'immobilier_delete');

        return array(
            'immobilier' => $immobilier,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Immobilier entity.
     *
     * @Route("/{id}/update", name="immobilier_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("GeranceBundle:Immobilier:edit.html.twig")
     */
    public function updateAction(Immobilier $immobilier, Request $request)
    {
        $editForm = $this->createForm(ImmobilierType::class, $immobilier, array(
            'action' => $this->generateUrl('immobilier_update', array('id' => $immobilier->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            echo 3;
            die();
        }
        $deleteForm = $this->createDeleteForm($immobilier->getId(), 'immobilier_delete');

        return array(
            'immobilier' => $immobilier,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Immobilier entity.
     *
     * @Route("/{id}/delete", name="immobilier_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Immobilier $immobilier, Request $request)
    {
        $form = $this->createDeleteForm($immobilier->getId(), 'immobilier_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($immobilier);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('immobilier'));
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
