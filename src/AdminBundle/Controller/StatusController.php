<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Status;
use AdminBundle\Form\Type\StatusType;

/**
 * Status controller.
 *
 * @Route("/admin/status")
 */
class StatusController extends Controller
{
    /**
     * Lists all Status entities.
     *
     * @Route("/", name="admin_status")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Status')->findAll();

        return $this->render('AdminBundle:status:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Status entity.
     *
     * @Route("/{id}/show", name="admin_status_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Status $status)
    {
        $deleteForm = $this->createDeleteForm($status->getId(), 'admin_status_delete');

        return $this->render('AdminBundle:status:show.html.twig', array(
            'status' => $status,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Status entity.
     *
     * @Route("/new", name="admin_status_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);

        return $this->render('AdminBundle:status:new.html.twig', array(
            'status' => $status,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Status entity.
     *
     * @Route("/create", name="admin_status_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_status_show', array('id' => $status->getId())));
        }

        return $this->render('AdminBundle:status:new.html.twig', array(
            'status' => $status,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Status entity.
     *
     * @Route("/{id}/edit", name="admin_status_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(Status $status)
    {
        $editForm = $this->createForm(StatusType::class, $status, array(
            'action' => $this->generateUrl('admin_status_update', array('id' => $status->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($status->getId(), 'admin_status_delete');

        return $this->render('AdminBundle:status:edit.html.twig', array(
            'status' => $status,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Status entity.
     *
     * @Route("/{id}/update", name="admin_status_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(Status $status, Request $request)
    {
        $editForm = $this->createForm(StatusType::class, $status, array(
            'action' => $this->generateUrl('admin_status_update', array('id' => $status->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_status_edit', array('id' => $status->getId())));
        }
        $deleteForm = $this->createDeleteForm($status->getId(), 'admin_status_delete');

        return $this->render('AdminBundle:status:edit.html.twig', array(
            'status' => $status,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Status entity.
     *
     * @Route("/{id}/delete", name="admin_status_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Status $status, Request $request)
    {
        $form = $this->createDeleteForm($status->getId(), 'admin_status_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($status);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_status'));
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
