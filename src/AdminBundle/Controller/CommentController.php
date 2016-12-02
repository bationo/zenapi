<?php

namespace AdminBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Comment;

/**
 * Comment controller.
 *
 * @Route("/admin/comments")
 */
class CommentController extends Controller
{
    /**
     * Lists all Comment entities.
     *
     * @Route("/", name="admin_comments")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Comment')->findAll();

        return $this->render('AdminBundle:comment:index.html.twig', array(
            'entities'  => $entities,
        ));
    }

    /**
     * Finds and displays a Comment entity.
     *
     * @Route("/{id}/show", name="admin_comments_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Comment $comment)
    {
        $approveForm = $this->createCustomForm($comment->getId(), 'admin_comments_approve', 'POST', 'approve');
        $disapproveForm = $this->createCustomForm($comment->getId(), 'admin_comments_disapprove', 'POST', 'disapprove');
        $deleteForm = $this->createCustomForm($comment->getId(), 'admin_comments_delete', 'DELETE', 'delete');

        return $this->render('AdminBundle:comment:show.html.twig', array(
            'comment'         => $comment,
            'approve_form'    => $approveForm->createView(),
            'disapprove_form' => $disapproveForm->createView(),
            'delete_form'     => $deleteForm->createView(),
        ));
    }

    /**
     * Approves a Comment entity.
     *
     * @Route("/{id}/approve", name="admin_comments_approve", requirements={"id"="\d+"})
     * @Method("POST")
     */
    public function approveAction(Comment $comment, Request $request)
    {
        $form = $this->createCustomForm($comment->getId(), 'admin_comments_approve', 'POST', 'approve');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $publish_state = $em->getRepository('AdminBundle:State')->findOneBySlug('publie');
            $comment->setState($publish_state);
            $em->persist($comment);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_comments'));
    }

    /**
     * Disapproves a Comment entity.
     *
     * @Route("/{id}/disapprove", name="admin_comments_disapprove", requirements={"id"="\d+"})
     * @Method("POST")
     */
    public function disapproveAction(Comment $comment, Request $request)
    {
        $form = $this->createCustomForm($comment->getId(), 'admin_comments_disapprove', 'POST', 'disapprove');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $trash_state = $em->getRepository('AdminBundle:State')->findOneBySlug('corbeille');
            $comment->setState($trash_state);
            $em->persist($comment);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_comments'));
    }

    /**
     * Deletes a Comment entity.
     *
     * @Route("/{id}/delete", name="admin_comments_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Comment $comment, Request $request)
    {
        $form = $this->createCustomForm($comment->getId(), 'admin_comments_delete', 'DELETE', 'delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_comments'));
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
