<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AdminBundle\Entity\Specialite;
use AdminBundle\Form\Type\SpecialiteEditType;
use AdminBundle\Form\Type\SpecialiteType; 

/**
 * Specialite controller.
 *
 * @Route("/pro/specialite")
 */
class SpecialiteController extends Controller
{
    /**
     * Lists all Specialite entities.
     *
     * @Route("/", name="specialite")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Specialite')->findBy( array(  "professionnel" => $this->getUser()->getProfessionnel()  ) );
        
      
		return $this->render('specialite/index.html.twig', array(   'entities'   => $entities ));	
    }

    /**
     * Finds and displays a Specialite entity.
     *
     * @Route("/{id}/show", name="specialite_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Specialite $specialite)
    {
        $deleteForm = $this->createDeleteForm($specialite->getId(), 'specialite_delete');

		if($this->getUser()->getProfessionnel()->getId() == $specialite->getProfessionnel()->getId() ){
			return $this->render('specialite/show.html.twig', array(   'specialite' => $specialite,
            'delete_form' => $deleteForm->createView(), ));
		}else{
			return $this->redirect($this->generateUrl('homepro'));
		}
		
    }

    /**
     * Displays a form to create a new Specialite entity.
     *
     * @Route("/new", name="specialite_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $specialite = new Specialite();
        $form = $this->createForm( SpecialiteType::class, $specialite);

      
		
		return $this->render('specialite/new.html.twig', array(   'specialite' => $specialite,
            'form'   => $form->createView(),
			
			));
    }

    /**
     * Creates a new Specialite entity.
     *
     * @Route("/create", name="specialite_create")
     * @Method("POST")
     * @Template("AdminBundle:Specialite:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $specialite = new Specialite();
        $form = $this->createForm(SpecialiteType::class, $specialite);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
			$specialite->setProfessionnel($this->getUser()->getProfessionnel());
            $em->persist($specialite);
            $em->flush();

            return $this->redirect($this->generateUrl('specialite_show', array('id' => $specialite->getId())));
        }

       
		
		return $this->render('specialite/new.html.twig', array(   'specialite' => $specialite,
            'form'   => $form->createView(),
			
			));
    }

    /**
     * Displays a form to edit an existing Specialite entity.
     *
     * @Route("/{id}/edit", name="specialite_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Specialite $specialite)
    {
        
		
		if($this->getUser()->getProfessionnel()->getId() == $specialite->getProfessionnel()->getId() ){
				$editForm = $this->createForm(SpecialiteType::class, $specialite, array(
            'action' => $this->generateUrl('specialite_update', array('id' => $specialite->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($specialite->getId(), 'specialite_delete');


		
		return $this->render('specialite/edit.html.twig', array(   'specialite' => $specialite,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
			
			));
		}else{
			return $this->redirect($this->generateUrl('homepro'));
		}
		
		
	
    }

    /**
     * Edits an existing Specialite entity.
     *
     * @Route("/{id}/update", name="specialite_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AdminBundle:Specialite:edit.html.twig")
     */
    public function updateAction(Specialite $specialite, Request $request)
    {
       
		if($this->getUser()->getProfessionnel()->getId() == $specialite->getProfessionnel()->getId() ){
			$editForm = $this->createForm(SpecialiteType::class, $specialite, array(
            'action' => $this->generateUrl('specialite_update', array('id' => $specialite->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
			$request->getSession()->getFlashBag()->add('notice', 'operation reussie');
            return $this->redirect($this->generateUrl('specialite_edit', array('id' => $specialite->getId())));
        }
        $deleteForm = $this->createDeleteForm($specialite->getId(), 'specialite_delete');

       
		
		return $this->render('specialite/edit.html.twig', array(    'specialite' => $specialite,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
			
			));
		}else{
			return $this->redirect($this->generateUrl('homepro'));
		}



	   
    }

    /**
     * Deletes a Specialite entity.
     *
     * @Route("/{id}/delete", name="specialite_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Specialite $specialite, Request $request)
    {
       if($this->getUser()->getProfessionnel()->getId() != $specialite->getProfessionnel()->getId() ){
		   return $this->redirect($this->generateUrl('homepro'));
	   }



	   $form = $this->createDeleteForm($specialite->getId(), 'specialite_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specialite);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('specialite'));
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
