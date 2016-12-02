<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AdminBundle\Entity\Place;
use AdminBundle\Form\Type\PlaceType;

/**
 * Place controller.
 *
 * @Route("/admin/place")
 */
class PlaceController extends Controller
{
    /**
     * Lists all Place entities.
     *
     * @Route("/", name="admin_place")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Place')->findAll();

        return $this->render('AdminBundle:place:index.html.twig', array(
            'entities'  => $entities,
        ));
    }

    /**
     * Finds and displays a Place entity.
     *
     * @Route("/{id}/show", name="admin_place_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Place $place)
    {
        $disapproveForm = $this->createCustomForm($place->getId(), 'admin_place_trash', 'DELETE', 'disapprove');
        $deleteForm = $this->createDeleteForm($place->getId(), 'admin_place_delete');

        return $this->render('AdminBundle:place:show.html.twig', array(
            'place'            => $place,
            'disapprove_form' => $disapproveForm->createView(),
            'delete_form'     => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Place entity.
     *
     * @Route("/new", name="admin_place_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);

        return $this->render('AdminBundle:place:new.html.twig', array(
            'place' => $place,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Place entity.
     *
     * @Route("/create", name="admin_place_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_place_show', array('id' => $place->getId())));
        }

        return $this->render('AdminBundle:place:new.html.twig', array(
            'place' => $place,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Place entity.
     *
     * @Route("/{id}/edit", name="admin_place_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(Place $place)
    {
        $editForm = $this->createForm(PlaceType::class, $place, array(
            'action' => $this->generateUrl('admin_place_update', array('id' => $place->getId())),
            'method' => 'PUT',
        ));
        $disapproveForm = $this->createCustomForm($place->getId(), 'admin_place_trash', 'DELETE', 'disapprove');

        return $this->render('AdminBundle:place:edit.html.twig', array(
            'place' => $place,
            'edit_form'   => $editForm->createView(),
            'disapprove_form' => $disapproveForm->createView(),
        ));
    }

    /**
     * Edits an existing Place entity.
     *
     * @Route("/{id}/update", name="admin_place_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(Place $place, Request $request)
    {
        $editForm = $this->createForm(PlaceType::class, $place, array(
            'action' => $this->generateUrl('admin_place_update', array('id' => $place->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_place_edit', array('id' => $place->getId())));
        }
        $disapproveForm = $this->createCustomForm($place->getId(), 'admin_place_trash', 'DELETE', 'disapprove');

        return $this->render('AdminBundle:place:edit.html.twig', array(
            'place' => $place,
            'edit_form'   => $editForm->createView(),
            'disapprove_form' => $disapproveForm->createView(),
        ));
    }

    /**
     * Trash a Place entity.
     *
     * @Route("/{id}/trash", name="admin_place_trash", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function trashAction(Place $place, Request $request)
    {
        $form = $this->createDeleteForm($place->getId(), 'admin_place_trash');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $trash_state = $em->getRepository('AdminBundle:State')->findOneBySlug('corbeille');
            $place->setState($trash_state);
            $em->persist($place);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_place'));
    }

    /**
     * Deletes a Place entity.
     *
     * @Route("/{id}/delete", name="admin_place_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Place $place, Request $request)
    {
        $form = $this->createDeleteForm($place->getId(), 'admin_place_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($place);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_place'));
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

    /**
     * Create form
     *
     * @param integer                       $id
     * @param string                        $route
     * @param string                        $method
     * @return \Symfony\Component\Form\Form
     */
    protected function createCustomForm($id, $route, $method, $form_id)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => $form_id)))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod($method)
            ->getForm()
            ;
    }

}
