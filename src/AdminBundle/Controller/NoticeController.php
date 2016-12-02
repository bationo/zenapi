<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Notice;

/**
 * Notice controller.
 *
 * @Route("/admin/notices")
 */
class NoticeController extends Controller
{
    /**
     * Lists all Notice entities.
     *
     * @Route("/", name="admin_notices")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Notice')->findAll();

        return $this->render('AdminBundle:notice:index.html.twig', array(
            'entities'  => $entities,
        ));
    }

    /**
     * Finds and displays a Notice entity.
     *
     * @Route("/{id}/show", name="admin_notices_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Notice $notice)
    {
        $approveForm = $this->createCustomForm($notice->getId(), 'admin_notices_approve', 'POST', 'approve');
        $disapproveForm = $this->createCustomForm($notice->getId(), 'admin_notices_disapprove', 'POST', 'disapprove');
        $deleteForm = $this->createCustomForm($notice->getId(), 'admin_notices_delete', 'DELETE', 'delete');

        return $this->render('AdminBundle:notice:show.html.twig', array(
            'notice'         => $notice,
            'approve_form'    => $approveForm->createView(),
            'disapprove_form' => $disapproveForm->createView(),
            'delete_form'     => $deleteForm->createView(),
        ));
    }

    /**
     * Approves a Notice entity.
     *
     * @Route("/{id}/approve", name="admin_notices_approve", requirements={"id"="\d+"})
     * @Method("POST")
     */
    public function approveAction(Notice $notice, Request $request)
    {
        $form = $this->createCustomForm($notice->getId(), 'admin_notices_approve', 'POST', 'approve');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $publish_state = $em->getRepository('AdminBundle:State')->findOneBySlug('publie');
            $notice->setState($publish_state);
            $em->persist($notice);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_notices'));
    }

    /**
     * Disapproves a Notice entity.
     *
     * @Route("/{id}/disapprove", name="admin_notices_disapprove", requirements={"id"="\d+"})
     * @Method("POST")
     */
    public function disapproveAction(Notice $notice, Request $request)
    {
        $form = $this->createCustomForm($notice->getId(), 'admin_notices_disapprove', 'POST', 'disapprove');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $trash_state = $em->getRepository('AdminBundle:State')->findOneBySlug('corbeille');
            $notice->setState($trash_state);
            $em->persist($notice);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_notices'));
    }

    /**
     * Deletes a Notice entity.
     *
     * @Route("/{id}/delete", name="admin_notices_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Notice $notice, Request $request)
    {
        $form = $this->createCustomForm($notice->getId(), 'admin_notices_delete', 'DELETE', 'delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notice);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_notices'));
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
