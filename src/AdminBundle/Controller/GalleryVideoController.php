<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\GalleryVideo;
use AdminBundle\Form\Type\GalleryVideoType;

/**
 * GalleryVideo controller.
 *
 * @Route("/admin/gallery_video")
 */
class GalleryVideoController extends Controller
{
    /**
     * Lists all GalleryVideo entities.
     *
     * @Route("/", name="admin_gallery_video")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:GalleryVideo')->findAll();
        
        return $this->render('AdminBundle:galleryvideo:index.html.twig', array(
            'entities'  => $entities,
        ));
    }

    /**
     * Finds and displays a GalleryVideo entity.
     *
     * @Route("/{id}/show", name="admin_gallery_video_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(GalleryVideo $galleryvideo)
    {
        $deleteForm = $this->createDeleteForm($galleryvideo->getId(), 'admin_gallery_video_delete');

        return $this->render('AdminBundle:galleryvideo:show.html.twig', array(
            'video' => $galleryvideo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new GalleryVideo entity.
     *
     * @Route("/new", name="admin_gallery_video_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $galleryvideo = new GalleryVideo();
        $form = $this->createForm(GalleryVideoType::class, $galleryvideo);

        return $this->render('AdminBundle:galleryvideo:new.html.twig', array(
            'video' => $galleryvideo,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new GalleryVideo entity.
     *
     * @Route("/create", name="admin_gallery_video_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $galleryvideo = new GalleryVideo();
        $form = $this->createForm(GalleryVideoType::class, $galleryvideo);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($galleryvideo);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gallery_video_show', array('id' => $galleryvideo->getId())));
        }

        return $this->render('AdminBundle:galleryvideo:new.html.twig', array(
            'video' => $galleryvideo,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GalleryVideo entity.
     *
     * @Route("/{id}/edit", name="admin_gallery_video_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(GalleryVideo $galleryvideo)
    {
        $editForm = $this->createForm(GalleryVideoType::class, $galleryvideo, array(
            'action' => $this->generateUrl('admin_gallery_video_update', array('id' => $galleryvideo->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($galleryvideo->getId(), 'admin_gallery_video_delete');

        return $this->render('AdminBundle:galleryvideo:edit.html.twig', array(
            'video' => $galleryvideo,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing GalleryVideo entity.
     *
     * @Route("/{id}/update", name="admin_gallery_video_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(GalleryVideo $galleryvideo, Request $request)
    {
        $editForm = $this->createForm(GalleryVideoType::class, $galleryvideo, array(
            'action' => $this->generateUrl('admin_gallery_video_update', array('id' => $galleryvideo->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_gallery_video_edit', array('id' => $galleryvideo->getId())));
        }
        $deleteForm = $this->createDeleteForm($galleryvideo->getId(), 'admin_gallery_video_delete');

        return $this->render('AdminBundle:galleryvideo:edit.html.twig', array(
            'video' => $galleryvideo,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a GalleryVideo entity.
     *
     * @Route("/{id}/delete", name="admin_gallery_video_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(GalleryVideo $galleryvideo, Request $request)
    {
        $form = $this->createDeleteForm($galleryvideo->getId(), 'admin_gallery_video_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($galleryvideo);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_gallery_video'));
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
