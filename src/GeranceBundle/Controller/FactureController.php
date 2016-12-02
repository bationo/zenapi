<?php

namespace GeranceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GeranceBundle\Entity\Facture;
use UserBundle\Entity\Locataire;
use GeranceBundle\Form\Type\FactureType;

/**
 * Facture controller.
 *
 * @Route("/facture")
 */
class FactureController extends Controller
{
    /**
     * Lists all Facture entities.
     *
     * @Route("/{id}", name="facture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Locataire $locataire)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('GeranceBundle:Facture')->findBy(array('locataire' => $locataire->getId() ));
        
        return array(
            'entities'  => $entities,
            'locataire'  => $locataire,
        );
    }

    /**
     * Finds and displays a Facture entity.
     *
     * @Route("/{id}/show", name="facture_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Facture $facture)
    {
        $deleteForm = $this->createDeleteForm($facture->getId(), 'facture_delete');

        return array(
            'facture' => $facture,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Facture entity.
     *
     * @Route("/new/{id}", name="facture_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Locataire $locataire)
    {
        $facture = new Facture();
        $form = $this->createForm( FactureType::class, $facture);
		$immobilier = $locataire->getProprietaire()->getImmobilier();
		$locative = array();
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
						}
					}else{
						$locative[] = $val;
					}
				}
			
		}

        return array(
            'facture' => $facture,
            'form'   => $form->createView(),
            "locataire" => $locataire,
			 "locative" => $locative,
        );
    }

    /**
     * Creates a new Facture entity.
     *
     * @Route("/create/{id}", name="facture_create")
     * @Method("POST")
     * @Template("GeranceBundle:Facture:new.html.twig")
     */
    public function createAction(Request $request, Locataire $locataire)
    {
        $facture = new Facture();
        $form = $this->createForm( FactureType::class, $facture);
		$immobilier = $locataire->getProprietaire()->getImmobilier();
		$locative = array();
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
						}
					}else{
						$locative[] = $val;
					}
				}
			
		}
		
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $facture->setLocataire($locataire);
            $em->persist($facture);
            $em->flush();

            return $this->redirect($this->generateUrl('facture_show', array('id' => $facture->getId())));
        }

        return array(
            'facture' => $facture,
            'form'   => $form->createView(),
            "locataire" => $locataire,
			 "locative" => $locative,
        );
    }

    /**
     * Displays a form to edit an existing Facture entity.
     *
     * @Route("/{id}/edit", name="facture_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Facture $facture)
    {
        $editForm = $this->createForm(FactureType::class, $facture, array(
            'action' => $this->generateUrl('facture_update', array('id' => $facture->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($facture->getId(), 'facture_delete');

        return array(
            'facture' => $facture,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Facture entity.
     *
     * @Route("/{id}/update", name="facture_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("GeranceBundle:Facture:edit.html.twig")
     */
    public function updateAction(Facture $facture, Request $request)
    {
        $editForm = $this->createForm( FactureType::class, $facture, array(
            'action' => $this->generateUrl('facture_update', array('id' => $facture->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('facture_edit', array('id' => $facture->getId())));
        }
        $deleteForm = $this->createDeleteForm($facture->getId(), 'facture_delete');

        return array(
            'facture' => $facture,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Facture entity.
     *
     * @Route("/{id}/delete", name="facture_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Facture $facture, Request $request)
    {
        $form = $this->createDeleteForm($facture->getId(), 'facture_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($facture);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('facture'));
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
