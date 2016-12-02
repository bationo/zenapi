<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Message;
use AdminBundle\Form\Type\MessageType;

/**
 * Message controller.
 *
 * @Route("/admin/messages")
 */
class MessageController extends Controller
{
    /**
     * Lists all Message entities.
     *
     * @Route("/", name="admin_messages")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Message')->findAll();
        
        return $this->render('AdminBundle:message:index.html.twig', array(
            'entities'  => $entities,
        ));
    }

    /**
     * Finds and displays a Message entity.
     *
     * @Route("/{id}/show", name="admin_messages_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Message $message)
    {
        $deleteForm = $this->createDeleteForm($message->getId(), 'admin_messages_delete');

        return $this->render('AdminBundle:message:show.html.twig', array(
            'message' => $message,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Message entity.
     *
     * @Route("/new", name="admin_messages_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        return $this->render('AdminBundle:message:new.html.twig', array(
            'message' => $message,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Message entity.
     *
     * @Route("/create", name="admin_messages_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_messages_show', array('id' => $message->getId())));
        }

        return $this->render('AdminBundle:message:new.html.twig', array(
            'message' => $message,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Message entity.
     *
     * @Route("/{id}/edit", name="admin_messages_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(Message $message)
    {
        $editForm = $this->createForm(MessageType::class, $message, array(
            'action' => $this->generateUrl('admin_messages_update', array('id' => $message->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($message->getId(), 'admin_messages_delete');

        return $this->render('AdminBundle:message:edit.html.twig', array(
            'message' => $message,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Message entity.
     *
     * @Route("/{id}/update", name="admin_messages_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(Message $message, Request $request)
    {
        $editForm = $this->createForm(MessageType::class, $message, array(
            'action' => $this->generateUrl('admin_messages_update', array('id' => $message->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_messages_edit', array('id' => $message->getId())));
        }
        $deleteForm = $this->createDeleteForm($message->getId(), 'admin_messages_delete');

        return $this->render('AdminBundle:message:edit.html.twig', array(
            'message' => $message,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Message entity.
     *
     * @Route("/{id}/delete", name="admin_messages_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Message $message, Request $request)
    {
        $form = $this->createDeleteForm($message->getId(), 'admin_messages_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_messages'));
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
