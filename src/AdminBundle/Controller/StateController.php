<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\State;
use AdminBundle\Form\Type\StateType;

/**
 * State controller.
 *
 * @Route("/admin/states")
 */
class StateController extends Controller
{
    /**
     * Lists all State entities.
     *
     * @Route("/", name="admin_states")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:State')->findAll();

        return $this->render('AdminBundle:state:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a State entity.
     *
     * @Route("/{id}/show", name="admin_states_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(State $state)
    {
        $deleteForm = $this->createDeleteForm($state->getId(), 'admin_states_delete');

        return $this->render('AdminBundle:state:show.html.twig', array(
            'state' => $state,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new State entity.
     *
     * @Route("/new", name="admin_states_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $state = new State();
        $form = $this->createForm(StateType::class, $state);

        return $this->render('AdminBundle:state:new.html.twig', array(
            'state' => $state,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new State entity.
     *
     * @Route("/create", name="admin_states_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $state = new State();
        $form = $this->createForm(StateType::class, $state);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($state);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_states_show', array('id' => $state->getId())));
        }

        return $this->render('AdminBundle:state:new.html.twig', array(
            'state' => $state,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing State entity.
     *
     * @Route("/{id}/edit", name="admin_states_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(State $state)
    {
        $editForm = $this->createForm(StateType::class, $state, array(
            'action' => $this->generateUrl('admin_states_update', array('id' => $state->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($state->getId(), 'admin_states_delete');

        return $this->render('AdminBundle:state:edit.html.twig', array(
            'state' => $state,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing State entity.
     *
     * @Route("/{id}/update", name="admin_states_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(State $state, Request $request)
    {
        $editForm = $this->createForm(StateType::class, $state, array(
            'action' => $this->generateUrl('admin_states_update', array('id' => $state->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_states_edit', array('id' => $state->getId())));
        }
        $deleteForm = $this->createDeleteForm($state->getId(), 'admin_states_delete');

        return $this->render('AdminBundle:state:edit.html.twig', array(
            'state' => $state,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a State entity.
     *
     * @Route("/{id}/delete", name="admin_states_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(State $state, Request $request)
    {
        $form = $this->createDeleteForm($state->getId(), 'admin_states_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($state);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_states'));
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
