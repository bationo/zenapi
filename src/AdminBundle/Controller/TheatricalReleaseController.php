<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Place;
use AdminBundle\Form\Type\TheatricalReleaseType;
use AdminBundle\Entity\TheatricalRelease;

/**
 * Place controller.
 *
 * @Route("/admin/theatrical_release")
 */
class TheatricalReleaseController extends Controller
{
    /**
     * Lists all TheatricalRelease entities.
     *
     * @Route("/{id}", name="admin_theatrical_release", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function indexAction(Place $place)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:TheatricalRelease')->findByPlace($place);

        return $this->render('AdminBundle:theatricalrelease:index.html.twig', array(
            'place'    => $place,
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a TheatricalRelease entity.
     *
     * @Route("/{id}/show", name="admin_theatrical_release_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(TheatricalRelease $theatricalRelease)
    {
        $deleteForm = $this->createDeleteForm($theatricalRelease->getId(), 'admin_theatrical_release_delete');

        return $this->render('AdminBundle:theatricalrelease:show.html.twig', array(
            'theatricalrelease' => $theatricalRelease,
            'delete_form'       => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new TheatricalRelease entity.
     *
     * @Route("/{id}/create", name="admin_theatrical_release_create", requirements={"id"="\d+"})
     * @Method({"GET","POST"})
     */
    public function createAction(Place $place, Request $request)
    {
        $theatricalRelease = new TheatricalRelease();
        $theatricalRelease->setPlace($place);

        $form = $this->createForm(TheatricalReleaseType::class, $theatricalRelease);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($theatricalRelease);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_theatrical_release_show', array('id' => $theatricalRelease->getId())));
        }

        return $this->render('AdminBundle:theatricalrelease:new.html.twig', array(
            'theatricalrelease' => $theatricalRelease,
            'place'             => $place,
            'form'              => $form->createView(),
        ));
    }


    /**
     * Displays a form to update an existing TheatricalRelease entity.
     *
     * @Route("/{id}/update", name="admin_theatrical_release_update", requirements={"id"="\d+"})
     * @Method({"GET","POST"})
     */
    public function updateAction(TheatricalRelease $theatricalRelease, Request $request)
    {

        $editForm = $this->createForm(TheatricalReleaseType::class, $theatricalRelease, array(
            'action' => $this->generateUrl('admin_theatrical_release_update', array('id' => $theatricalRelease->getId())),
            'method' => 'POST',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_theatrical_release_update', array('id' => $theatricalRelease->getId())));
        }
        $deleteForm = $this->createDeleteForm($theatricalRelease->getId(), 'admin_theatrical_release_delete');

        return $this->render('AdminBundle:theatricalrelease:edit.html.twig', array(
            'theatricalrelease' => $theatricalRelease,
            'edit_form'         => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TheatricalRelease entity.
     *
     * @Route("/{id}/delete", name="admin_theatrical_release_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(TheatricalRelease $theatricalRelease, Request $request)
    {
        $form = $this->createDeleteForm($theatricalRelease->getId(), 'admin_theatrical_release_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($theatricalRelease);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_theatrical_release', array('id' => $theatricalRelease->getPlace()->getId())));
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
