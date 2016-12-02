<?php

namespace GeranceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GeranceBundle\Entity\Locative;
use GeranceBundle\Entity\Immobilier;
use GeranceBundle\Form\Type\LocativeType;

/**
 * Locative controller.
 *
 * @Route("/locative")
 */
class LocativeController extends Controller
{
    /**
     * Lists all Locative entities.
     *
     * @Route("/{id}", name="locative")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Immobilier $immobilier)
    {

        if($immobilier->getVente()== true){
            return $this->redirect($this->generateUrl('immobilier', array('id' => $immobilier->getProprietaire()->getId())));
        }

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('GeranceBundle:Locative')->findBy(  array("immobilier" => $immobilier->getId() ) );
        
        return array(
            'entities'  => $entities,
			'immobilier'  => $immobilier,
        );
    }

    /**
     * Finds and displays a Locative entity.
     *
     * @Route("/{id}/show", name="locative_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Locative $locative)
    {
        $deleteForm = $this->createDeleteForm($locative->getId(), 'locative_delete');

        return array(
            'locative' => $locative,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Locative entity.
     *
     * @Route("/new/{id}", name="locative_new")
     * @Template()
     */
    public function newAction(Immobilier $immobilier)
    {
       if($immobilier->getVente()== true){
            return $this->redirect($this->generateUrl('immobilier', array('id' => $immobilier->getProprietaire()->getId())));
        }

        $locative = new Locative();
        $form = $this->createForm( LocativeType::class, $locative);

        return array(
            'locative' => $locative,
			'immobilier' => $immobilier,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Locative entity.
     *
     * @Route("/create/{id}", name="locative_create")
     * @Method("POST")
     * @Template("GeranceBundle:Locative:new.html.twig")
     */
    public function createAction(Request $request , Immobilier $immobilier)
    {
        if($immobilier->getVente()== true){
            return $this->redirect($this->generateUrl('immobilier', array('id' => $immobilier->getProprietaire()->getId())));
        }
        
        $locative = new Locative();
        $form = $this->createForm( LocativeType::class, $locative);
        if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
             $entities = $em->getRepository('GeranceBundle:Locative')->findBy(  array("immobilier" => $immobilier->getId() , "porte" => $locative->getPorte() ) );
			if(!$entities){
				
				$locative->setImmobilier($immobilier);
				$em->persist($locative);
				$em->flush();

				echo 3;
				die();
				
			}else{
				$request->getSession()->getFlashBag()->add('noticee', 'il existe déja une locative avec ce numéro de porte !');
			}
			
			

        }

        return array(
            'locative' => $locative,
			'immobilier' => $immobilier,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Locative entity.
     *
     * @Route("/{id}/edit", name="locative_edit")
     * @Template()
     */
    public function editAction(Locative $locative)
    {
        $editForm = $this->createForm(LocativeType::class, $locative, array(
            'action' => $this->generateUrl('locative_update', array('id' => $locative->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($locative->getId(), 'locative_delete');

        return array(
            'locative' => $locative,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Locative entity.
     *
     * @Route("/{id}/update", name="locative_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("GeranceBundle:Locative:edit.html.twig")
     */
    public function updateAction(Locative $locative, Request $request)
    {
        $editForm = $this->createForm( LocativeType::class, $locative, array(
            'action' => $this->generateUrl('locative_update', array('id' => $locative->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            echo 3;
            die();

            }
        $deleteForm = $this->createDeleteForm($locative->getId(), 'locative_delete');

        return array(
            'locative' => $locative,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Locative entity.
     *
     * @Route("/{id}/delete", name="locative_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Locative $locative, Request $request)
    {
        $form = $this->createDeleteForm($locative->getId(), 'locative_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($locative);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('locative'));
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
